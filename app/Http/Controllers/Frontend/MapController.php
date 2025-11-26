<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    /**
     * Affiche la carte interactive (centrée sur la Guinée)
     */
    public function index()
    {
        // Propriétés actives avec relations nécessaires
        $properties = Property::with(['type', 'user'])
            ->where('status', 1)
            ->select(
                'id', 'property_name', 'property_slug', 'property_thumbnail',
                'property_status', 'bedrooms', 'bathrooms', 'garage', 'property_size',
                'ptype_id', 'agent_id', 'city', 'state', 'postal_code', 'address',
                'lowest_price', 'max_price', 'latitude', 'longitude'
            )
            ->latest()
            ->get();

        $propertyTypes = PropertyType::all();

        // Mapper -> données pour la carte (on ignore les biens sans lat/lng)
        $mapData = $properties->filter(function ($p) {
            return !empty($p->latitude) && !empty($p->longitude);
        })->map(function ($p) {
            // Prix à afficher : vente -> max_price si dispo sinon lowest; location -> lowest_price
            $priceRaw = $this->pickPriceForStatus($p->property_status, $p->lowest_price, $p->max_price);
            return [
                'id'        => $p->id,
                'name'      => $p->property_name,
                'slug'      => $p->property_slug,
                'thumbnail' => $p->property_thumbnail ? asset($p->property_thumbnail) : null,
                'status'    => $p->property_status,
                'formatted_price' => currency_gnf($priceRaw),
                'address'   => trim(implode(', ', array_filter([$p->address, $p->city, $p->state]))),
                'bedrooms'  => $p->bedrooms,
                'bathrooms' => $p->bathrooms,
                'size'      => $p->property_size,
                'type'      => optional($p->type)->type_name ?: '',
                'agent'     => optional($p->user)->name ?: '',
                'lat'       => (float) $p->latitude,
                'lng'       => (float) $p->longitude,
                'url'       => route('property.details', [$p->id, $p->property_slug]),
            ];
        })->values();

        // Bounds de la Guinée pour fitBounds (approx)
        $guineaBounds = [
            'sw' => [7.0, -15.2],
            'ne' => [12.8, -7.4],
        ];

        return view('frontend.map.property_map', compact('mapData', 'propertyTypes', 'properties', 'guineaBounds'));
    }

    /**
     * Recherche par zone (bbox)
     */
    public function searchByArea(Request $request)
    {
        $request->validate([
            'north'         => 'required|numeric',
            'south'         => 'required|numeric',
            'east'          => 'required|numeric',
            'west'          => 'required|numeric',
            'property_type' => 'nullable|exists:property_types,id',
            // On accepte fr/en et on normalise ensuite
            'status'        => 'nullable|string|in:rent,sale,à louer,à vendre',
            'min_price'     => 'nullable|numeric|min:0',
            'max_price'     => 'nullable|numeric|min:0',
            'bedrooms'      => 'nullable|integer|min:0',
            'bathrooms'     => 'nullable|integer|min:0',
        ]);

        $query = Property::with(['type', 'user'])
            ->where('status', 1)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [$request->south, $request->north])
            ->whereBetween('longitude', [$request->west, $request->east]);

        if ($request->filled('property_type')) {
            $query->where('ptype_id', $request->property_type);
        }

        if ($request->filled('status')) {
            $normalized = $this->normalizeStatus($request->status);
            $query->where('property_status', $normalized);
        }

        // Filtres prix (on couvre lowest et max)
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $min = (float) $request->min_price;
            $max = (float) $request->max_price;
            $query->where(function ($q) use ($min, $max) {
                $q->whereBetween('lowest_price', [$min, $max])
                  ->orWhereBetween('max_price', [$min, $max]);
            });
        } elseif ($request->filled('min_price')) {
            $min = (float) $request->min_price;
            $query->where(function ($q) use ($min) {
                $q->where('lowest_price', '>=', $min)
                  ->orWhere('max_price', '>=', $min);
            });
        } elseif ($request->filled('max_price')) {
            $max = (float) $request->max_price;
            $query->where(function ($q) use ($max) {
                $q->where('lowest_price', '<=', $max)
                  ->orWhere('max_price', '<=', $max);
            });
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', (int) $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', (int) $request->bathrooms);
        }

        $properties = $query->get();

        $mapData = $properties->map(function ($p) {
            $priceRaw = $this->pickPriceForStatus($p->property_status, $p->lowest_price, $p->max_price);
            return [
                'id'        => $p->id,
                'name'      => $p->property_name,
                'slug'      => $p->property_slug,
                'thumbnail' => $p->property_thumbnail ? asset($p->property_thumbnail) : null,
                'status'    => $p->property_status,
                'formatted_price' => currency_gnf($priceRaw),
                'address'   => trim(implode(', ', array_filter([$p->address, $p->city, $p->state]))),
                'bedrooms'  => $p->bedrooms,
                'bathrooms' => $p->bathrooms,
                'size'      => $p->property_size,
                'type'      => optional($p->type)->type_name ?: '',
                'agent'     => optional($p->user)->name ?: '',
                'lat'       => (float) $p->latitude,
                'lng'       => (float) $p->longitude,
                'url'       => route('property.details', [$p->id, $p->property_slug]),
            ];
        })->values();

        return response()->json([
            'success'    => true,
            'count'      => $mapData->count(),
            'properties' => $mapData,
        ]);
    }

    /**
     * Recherche autour d'une adresse (Haversine)
     * NOTE: il te faudra brancher une vraie géocodification (Google/Mapbox).
     */
    public function searchByAddress(Request $request)
    {
        $request->validate([
            'address'       => 'required|string',
            'radius'        => 'required|numeric|min:1|max:50', // km
            'property_type' => 'nullable|exists:property_types,id',
            'status'        => 'nullable|string|in:rent,sale,à louer,à vendre',
        ]);

        // TODO: géocoder $request->address -> $latitude, $longitude
        // Pour l’instant : centre approximatif de la Guinée
        $latitude  = 10.43;
        $longitude = -10.94;
        $radius    = (float) $request->radius;

        $properties = Property::with(['type', 'user'])
            ->where('status', 1)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(DB::raw("*, 
                (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance"))
            ->having('distance', '<=', $radius);

        if ($request->filled('property_type')) {
            $properties->where('ptype_id', $request->property_type);
        }

        if ($request->filled('status')) {
            $properties->where('property_status', $this->normalizeStatus($request->status));
        }

        $properties = $properties->orderBy('distance')->get();

        $mapData = $properties->map(function ($p) {
            $priceRaw = $this->pickPriceForStatus($p->property_status, $p->lowest_price, $p->max_price);
            return [
                'id'        => $p->id,
                'name'      => $p->property_name,
                'slug'      => $p->property_slug,
                'thumbnail' => $p->property_thumbnail ? asset($p->property_thumbnail) : null,
                'status'    => $p->property_status,
                'formatted_price' => currency_gnf($priceRaw),
                'address'   => trim(implode(', ', array_filter([$p->address, $p->city, $p->state]))),
                'bedrooms'  => $p->bedrooms,
                'bathrooms' => $p->bathrooms,
                'size'      => $p->property_size,
                'type'      => optional($p->type)->type_name ?: '',
                'agent'     => optional($p->user)->name ?: '',
                'lat'       => (float) $p->latitude,
                'lng'       => (float) $p->longitude,
                'distance'  => isset($p->distance) ? round($p->distance, 2) . ' km' : null,
                'url'       => route('property.details', [$p->id, $p->property_slug]),
            ];
        })->values();

        return response()->json([
            'success'    => true,
            'count'      => $mapData->count(),
            'properties' => $mapData,
            'center'     => [
                'lat'     => $latitude,
                'lng'     => $longitude,
                'address' => $request->address,
            ],
        ]);
    }

    /**
     * Normalise le statut vers fr: 'à louer' / 'à vendre'
     */
    private function normalizeStatus(?string $status): ?string
    {
        if (!$status) return null;
        $s = mb_strtolower(trim($status));
        if (in_array($s, ['rent', 'à louer'])) return 'à louer';
        if (in_array($s, ['sale', 'à vendre'])) return 'à vendre';
        return $status; // fallback
        }

    /**
     * Retourne le prix à afficher selon le statut
     */
    private function pickPriceForStatus(?string $status, $lowest, $max)
    {
        $norm = $this->normalizeStatus($status);
        if ($norm === 'à louer') {
            return $lowest ?? $max ?? 0;
        }
        // vente
        return $max ?? $lowest ?? 0;
    }
}
