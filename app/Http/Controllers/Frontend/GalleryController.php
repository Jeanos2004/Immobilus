<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\PropertyType;

class GalleryController extends Controller
{
    /**
     * Affiche la galerie de photos
     */
    public function index()
    {
        // Récupérer les types de propriétés pour le filtre
        $propertyTypes = PropertyType::all();
        
        // Récupérer les propriétés avec leurs images
        $properties = Property::with('propertyImages')
            ->where('status', 1)
            ->inRandomOrder()
            ->paginate(12);
        
        // Compter le nombre total d'images
        $totalImages = MultiImage::count();
        
        return view('frontend.pages.gallery', compact('properties', 'propertyTypes', 'totalImages'));
    }
    
    /**
     * Filtrer la galerie par type de propriété
     */
    public function filterByType($typeId)
    {
        // Récupérer les types de propriétés pour le filtre
        $propertyTypes = PropertyType::all();
        
        // Récupérer les propriétés du type spécifié avec leurs images
        $properties = Property::with('propertyImages')
            ->where('status', 1)
            ->where('ptype_id', $typeId)
            ->paginate(12);
        
        // Compter le nombre total d'images pour ce type
        $totalImages = MultiImage::whereHas('property', function($query) use ($typeId) {
            $query->where('ptype_id', $typeId);
        })->count();
        
        $selectedType = PropertyType::findOrFail($typeId);
        
        return view('frontend.pages.gallery', compact('properties', 'propertyTypes', 'totalImages', 'selectedType'));
    }
    
    /**
     * Afficher les détails d'une image
     */
    public function showImage($id)
    {
        $image = MultiImage::with('property.user')->findOrFail($id);
        
        // Récupérer d'autres images de la même propriété
        $relatedImages = MultiImage::where('property_id', $image->property_id)
            ->where('id', '!=', $id)
            ->limit(6)
            ->get();
        
        return view('frontend.pages.gallery_detail', compact('image', 'relatedImages'));
    }
}
