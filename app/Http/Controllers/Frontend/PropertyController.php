<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PropertyController extends Controller
{
    /**
     * Affiche la liste de toutes les propriétés
     */
    public function PropertyList()
    {
        // Récupérer toutes les propriétés actives avec leurs relations
        $properties = Property::with(['type', 'user'])
                        ->where('status', 1)
                        ->latest()
                        ->paginate(9);
        
        // Récupérer les types de propriétés et aménités pour les filtres
        $propertyTypes = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        
        return view('frontend.property.property_list', compact('properties', 'propertyTypes', 'amenities'));
    }

    /**
     * Affiche les propriétés en mode grille
     */
    public function PropertyGrid()
    {
        // Récupérer toutes les propriétés actives avec leurs relations
        $properties = Property::with(['type', 'user'])
                        ->where('status', 1)
                        ->latest()
                        ->paginate(9);
        
        // Récupérer les types de propriétés et aménités pour les filtres
        $propertyTypes = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        
        return view('frontend.property.property_grid', compact('properties', 'propertyTypes', 'amenities'));
    }

    /**
     * Affiche les détails d'une propriété spécifique
     */
    public function PropertyDetails($id, $slug)
    {
        // Récupérer la propriété avec ses relations
        $property = Property::with(['type', 'user', 'amenities'])
                        ->where('id', $id)
                        ->where('status', 1)
                        ->first();
        
        // Si la propriété n'existe pas ou n'est pas active, rediriger vers la liste
        if (!$property) {
            return redirect()->route('property.list');
        }
        
        // Récupérer des propriétés similaires (même type, même statut)
        $similarProperties = Property::with(['type', 'user'])
                            ->where('ptype_id', $property->ptype_id)
                            ->where('property_status', $property->property_status)
                            ->where('id', '!=', $id)
                            ->where('status', 1)
                            ->limit(3)
                            ->get();
        
        return view('frontend.property.property_details', compact('property', 'similarProperties'));
    }

    /**
     * Recherche et filtre des propriétés
     */
    public function PropertySearch(Request $request)
    {
        // Initialiser la requête
        $query = Property::with(['type', 'user', 'amenities'])
                    ->where('status', 1);
        
        // Filtre par statut (à vendre/à louer)
        if ($request->has('status') && !empty($request->status)) {
            $query->where('property_status', $request->status);
        }
        
        // Filtre par recherche textuelle (adresse, ville, code postal)
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('property_name', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('postal_code', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtre par type de propriété
        if ($request->has('ptype_id') && !empty($request->ptype_id)) {
            $query->where('ptype_id', $request->ptype_id);
        }
        
        // Filtre par fourchette de prix
        if ($request->has('price_range') && !empty($request->price_range)) {
            $price_range = explode('-', $request->price_range);
            $min_price = $price_range[0];
            $max_price = $price_range[1];
            
            if ($max_price > 0) {
                $query->whereBetween('lowest_price', [$min_price, $max_price]);
            } else {
                $query->where('lowest_price', '>=', $min_price);
            }
        }
        
        // Filtre par nombre de chambres
        if ($request->has('bedrooms') && !empty($request->bedrooms)) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }
        
        // Filtre par nombre de salles de bain
        if ($request->has('bathrooms') && !empty($request->bathrooms)) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }
        
        // Filtre par aménité
        if ($request->has('amenities_id') && !empty($request->amenities_id)) {
            $amenities_id = $request->amenities_id;
            $query->whereHas('amenities', function($q) use ($amenities_id) {
                $q->where('amenities_id', $amenities_id);
            });
        }
        
        // Exécuter la requête et paginer les résultats
        $properties = $query->latest()->paginate(9);
        
        // Récupérer les types de propriétés et aménités pour les filtres
        $propertyTypes = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        
        return view('frontend.property.property_search', compact('properties', 'propertyTypes', 'amenities', 'request'));
    }

    /**
     * Affiche les propriétés par type
     */
    public function PropertyByType($id)
    {
        // Récupérer les propriétés du type spécifié
        $properties = Property::with(['type', 'user'])
                        ->where('ptype_id', $id)
                        ->where('status', 1)
                        ->latest()
                        ->paginate(9);
        
        // Récupérer le type de propriété
        $propertyType = PropertyType::findOrFail($id);
        
        // Récupérer les types de propriétés et aménités pour les filtres
        $propertyTypes = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        
        return view('frontend.property.property_by_type', compact('properties', 'propertyType', 'propertyTypes', 'amenities'));
    }

    /**
     * Affiche les propriétés d'un agent spécifique
     */
    public function AgentProperties($id = null)
    {
        // Vue publique des propriétés d'un agent spécifique
        if ($id) {
            $agent = User::where('role', 'agent')->findOrFail($id);

            $properties = Property::with(['type'])
                ->where('agent_id', $agent->id)
                ->where('status', 1)
                ->latest()
                ->paginate(9);

            return view('frontend.property.agent_properties', compact('properties', 'agent'));
        }

        // Vue du tableau de bord agent
        $agent = $this->currentAgent();

        $propertiesQuery = Property::with('type')
            ->where('agent_id', $agent->id)
            ->latest();

        $properties = $propertiesQuery->paginate(25);
        $statsCollection = Property::where('agent_id', $agent->id)->get();

        $stats = [
            'total' => $statsCollection->count(),
            'sell' => $statsCollection->where('property_status', 'à vendre')->count(),
            'rent' => $statsCollection->where('property_status', 'à louer')->count(),
            'views' => $statsCollection->sum('views'),
        ];

        return view('agent.properties.all_properties', compact('properties', 'stats'));
    }

    /**
     * Formulaire d'ajout d'une propriété pour l'agent connecté
     */
    public function AgentAddProperty()
    {
        $agent = $this->currentAgent();

        $propertyTypes = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();

        return view('agent.properties.add_property', compact('propertyTypes', 'amenities'));
    }

    /**
     * Enregistrement d'une nouvelle propriété par l'agent connecté
     */
    public function AgentStoreProperty(Request $request)
    {
        $agent = $this->currentAgent();

        $request->validate([
            'ptype_id' => 'required|exists:property_types,id',
            'property_name' => 'required|string|max:255',
            'property_status' => 'required|string',
            'lowest_price' => 'required',
            'property_thumbnail' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'bedrooms' => 'required|numeric',
            'bathrooms' => 'required|numeric',
            'garage' => 'nullable|numeric',
            'property_size' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $propertyCode = 'PC' . mt_rand(1000000, 9999999);

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move('upload/property/thumbnail/', $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        $property = Property::create([
            'ptype_id' => $request->ptype_id,
            'agent_id' => $agent->id,
            'property_name' => $request->property_name,
            'property_slug' => Str::slug($request->property_name),
            'property_code' => $propertyCode,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'property_thumbnail' => $save_url,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        if ($request->amenities_id) {
            $property->amenities()->sync($request->amenities_id);
        }

        $notification = [
            'message' => 'Propriété ajoutée avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('agent.properties.all')->with($notification);
    }
    /**
     * Retourne l'agent connecté ou lance une exception si non autorisé.
     */
    private function currentAgent()
    {
        $agent = Auth::user();

        if (!$agent || $agent->role !== 'agent') {
            abort(403, 'Accès non autorisé');
        }

        return $agent;
    }
}
