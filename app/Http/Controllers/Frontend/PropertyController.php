<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
    public function AgentProperties($id)
    {
        // Récupérer l'agent
        $agent = User::findOrFail($id);
        
        // Récupérer les propriétés de l'agent
        $properties = Property::with(['type'])
                        ->where('agent_id', $id)
                        ->where('status', 1)
                        ->latest()
                        ->paginate(9);
        
        return view('frontend.property.agent_properties', compact('properties', 'agent'));
    }
}
