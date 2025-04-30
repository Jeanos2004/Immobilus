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
     * Affiche la carte interactive avec toutes les propriétés
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer toutes les propriétés avec leurs coordonnées
        $properties = Property::with(['type', 'agent'])
            ->where('status', 1) // 1 = active dans votre table
            ->select('id', 'property_name', 'property_slug', 'property_thumbnail', 'property_status',
                'bedrooms', 'bathrooms', 'garage', 'property_size', 'ptype_id', 'agent_id',
                'city', 'state', 'postal_code', 'address', 'lowest_price', 'max_price', 'latitude', 'longitude')
            ->get();

        // Récupérer tous les types de propriétés pour le filtre
        $propertyTypes = PropertyType::all();
        
        // Préparer les données pour la carte
        $mapData = [];
        foreach ($properties as $property) {
            // Ne pas inclure les propriétés sans coordonnées
            if (!empty($property->latitude) && !empty($property->longitude)) {
                $mapData[] = [
                    'id' => $property->id,
                    'name' => $property->property_name,
                    'slug' => $property->property_slug,
                    'thumbnail' => $property->property_thumbnail,
                    'status' => $property->property_status,
                    'price' => $property->property_status == 'rent' ? $property->lowest_price : $property->max_price,
                    'address' => $property->address . ', ' . $property->city . ', ' . $property->state,
                    'bedrooms' => $property->bedrooms,
                    'bathrooms' => $property->bathrooms,
                    'size' => $property->property_size,
                    'type' => $property->type ? $property->type->type_name : '',
                    'agent' => $property->agent ? $property->agent->name : '',
                    'lat' => (float) $property->latitude,
                    'lng' => (float) $property->longitude,
                ];
            }
        }

        return view('frontend.map.property_map', compact('mapData', 'propertyTypes', 'properties'));
    }

    /**
     * Recherche de propriétés par zone géographique
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByArea(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'north' => 'required|numeric',
            'south' => 'required|numeric',
            'east' => 'required|numeric',
            'west' => 'required|numeric',
            'property_type' => 'nullable|exists:property_types,id',
            'status' => 'nullable|in:rent,sale',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
        ]);

        // Construire la requête de base
        $query = Property::with(['type', 'agent'])
            ->where('status', 1) // 1 = active dans votre table
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [$request->south, $request->north])
            ->whereBetween('longitude', [$request->west, $request->east]);

        // Appliquer les filtres si présents
        if ($request->filled('property_type')) {
            $query->where('ptype_id', $request->property_type);
        }

        if ($request->filled('status')) {
            $query->where('property_status', $request->status);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('lowest_price', [$request->min_price, $request->max_price])
                  ->orWhereBetween('max_price', [$request->min_price, $request->max_price]);
            });
        } elseif ($request->filled('min_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('lowest_price', '>=', $request->min_price)
                  ->orWhere('max_price', '>=', $request->min_price);
            });
        } elseif ($request->filled('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('lowest_price', '<=', $request->max_price)
                  ->orWhere('max_price', '<=', $request->max_price);
            });
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Récupérer les propriétés filtrées
        $properties = $query->get();

        // Formater les données pour la réponse JSON
        $mapData = [];
        foreach ($properties as $property) {
            $mapData[] = [
                'id' => $property->id,
                'name' => $property->property_name,
                'slug' => $property->property_slug,
                'thumbnail' => $property->property_thumbnail,
                'status' => $property->property_status,
                'price' => $property->property_status == 'rent' ? $property->lowest_price : $property->max_price,
                'address' => $property->address . ', ' . $property->city . ', ' . $property->state,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'size' => $property->property_size,
                'type' => $property->type ? $property->type->type_name : '',
                'agent' => $property->agent ? $property->agent->name : '',
                'lat' => (float) $property->latitude,
                'lng' => (float) $property->longitude,
                'url' => route('property.details', [$property->id, $property->property_slug]),
            ];
        }

        return response()->json([
            'success' => true,
            'count' => count($mapData),
            'properties' => $mapData
        ]);
    }

    /**
     * Recherche de propriétés à proximité d'une adresse
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByAddress(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'address' => 'required|string',
            'radius' => 'required|numeric|min:1|max:50', // Rayon en kilomètres
            'property_type' => 'nullable|exists:property_types,id',
            'status' => 'nullable|in:rent,sale',
        ]);

        // Convertir l'adresse en coordonnées (latitude, longitude) via une API externe
        // Note: Dans un environnement de production, vous utiliseriez une API comme Google Maps, Mapbox, etc.
        // Pour cet exemple, nous allons simuler cette conversion

        // Coordonnées fictives pour l'exemple (Paris)
        $latitude = 48.8566;
        $longitude = 2.3522;

        // Calcul de la distance avec la formule Haversine
        // Cette formule permet de calculer la distance entre deux points sur une sphère
        $radius = $request->radius; // Rayon en kilomètres

        // Construire la requête avec la formule Haversine
        $properties = Property::with(['type', 'agent'])
            ->where('status', 1) // 1 = active dans votre table
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(DB::raw("*, 
                (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance"))
            ->having('distance', '<=', $radius);

        // Appliquer les filtres si présents
        if ($request->filled('property_type')) {
            $properties->where('ptype_id', $request->property_type);
        }

        if ($request->filled('status')) {
            $properties->where('property_status', $request->status);
        }

        // Ordonner par distance et récupérer les résultats
        $properties = $properties->orderBy('distance')->get();

        // Formater les données pour la réponse JSON
        $mapData = [];
        foreach ($properties as $property) {
            $mapData[] = [
                'id' => $property->id,
                'name' => $property->property_name,
                'slug' => $property->property_slug,
                'thumbnail' => $property->property_thumbnail,
                'status' => $property->property_status,
                'price' => $property->property_status == 'rent' ? $property->lowest_price : $property->max_price,
                'address' => $property->address . ', ' . $property->city . ', ' . $property->state,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'size' => $property->property_size,
                'type' => $property->type ? $property->type->type_name : '',
                'agent' => $property->agent ? $property->agent->name : '',
                'lat' => (float) $property->latitude,
                'lng' => (float) $property->longitude,
                'distance' => round($property->distance, 2) . ' km',
                'url' => route('property.details', [$property->id, $property->property_slug]),
            ];
        }

        return response()->json([
            'success' => true,
            'count' => count($mapData),
            'properties' => $mapData,
            'center' => [
                'lat' => $latitude,
                'lng' => $longitude,
                'address' => $request->address
            ]
        ]);
    }
}
