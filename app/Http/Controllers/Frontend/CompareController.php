<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    /**
     * Affiche la page de comparaison des propriétés
     */
    public function index(Request $request)
    {
        $properties = [];
        $propertyIds = $request->input('properties', []);
        
        // Si aucune propriété n'est spécifiée, rediriger vers la liste des propriétés
        if (empty($propertyIds)) {
            return redirect()->route('property.list')
                ->with('alert-type', 'info')
                ->with('message', __('Veuillez sélectionner des propriétés à comparer.'));
        }
        
        // Limiter à 3 propriétés maximum pour la comparaison
        $propertyIds = array_slice($propertyIds, 0, 3);
        
        // Récupérer les propriétés à comparer
        $properties = Property::with(['type', 'propertyAmenities', 'user'])
            ->whereIn('id', $propertyIds)
            ->where('status', 1)
            ->get();
        
        // Si aucune propriété n'est trouvée, rediriger vers la liste des propriétés
        if ($properties->isEmpty()) {
            return redirect()->route('property.list')
                ->with('alert-type', 'error')
                ->with('message', __('Aucune propriété trouvée pour la comparaison.'));
        }
        
        // Récupérer toutes les commodités pour l'affichage
        $allAmenities = Amenity::all();
        
        return view('frontend.pages.compare', compact('properties', 'allAmenities'));
    }
    
    /**
     * Ajoute une propriété à la liste de comparaison (AJAX)
     */
    public function addToCompare(Request $request)
    {
        $propertyId = $request->input('property_id');
        
        // Vérifier si la propriété existe
        $property = Property::where('id', $propertyId)->where('status', 1)->first();
        
        if (!$property) {
            return response()->json([
                'status' => 'error',
                'message' => __('Propriété non trouvée.')
            ]);
        }
        
        // Récupérer la liste actuelle des propriétés à comparer depuis la session
        $compareList = session()->get('compare_list', []);
        
        // Vérifier si la propriété est déjà dans la liste
        if (in_array($propertyId, $compareList)) {
            return response()->json([
                'status' => 'info',
                'message' => __('Cette propriété est déjà dans votre liste de comparaison.')
            ]);
        }
        
        // Limiter à 3 propriétés maximum
        if (count($compareList) >= 3) {
            return response()->json([
                'status' => 'warning',
                'message' => __('Vous ne pouvez comparer que 3 propriétés maximum. Veuillez en retirer une avant d\'en ajouter une nouvelle.')
            ]);
        }
        
        // Ajouter la propriété à la liste
        $compareList[] = $propertyId;
        session()->put('compare_list', $compareList);
        
        return response()->json([
            'status' => 'success',
            'message' => __('Propriété ajoutée à la liste de comparaison.'),
            'count' => count($compareList)
        ]);
    }
    
    /**
     * Retire une propriété de la liste de comparaison
     */
    public function removeFromCompare(Request $request)
    {
        $propertyId = $request->input('property_id');
        
        // Récupérer la liste actuelle des propriétés à comparer
        $compareList = session()->get('compare_list', []);
        
        // Retirer la propriété de la liste
        $compareList = array_diff($compareList, [$propertyId]);
        session()->put('compare_list', array_values($compareList));
        
        return response()->json([
            'status' => 'success',
            'message' => __('Propriété retirée de la liste de comparaison.'),
            'count' => count($compareList)
        ]);
    }
    
    /**
     * Vide la liste de comparaison
     */
    public function clearCompare()
    {
        session()->forget('compare_list');
        
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('message', __('Liste de comparaison vidée avec succès.'));
    }
}
