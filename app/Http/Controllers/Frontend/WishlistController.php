<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Affiche la liste des propriétés favorites de l'utilisateur connecté
     * 
     * @return \Illuminate\View\View
     */
    public function WishlistIndex()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = Auth::user()->id;
        
        // Récupérer les propriétés favorites de l'utilisateur avec eager loading
        $wishlist = Favorite::with('property.type', 'property.user')
                            ->where('user_id', $user_id)
                            ->latest()
                            ->get();
        
        return view('frontend.wishlist.wishlist_view', compact('wishlist'));
    }
    
    /**
     * Ajoute une propriété aux favoris ou vérifie si elle est déjà dans les favoris
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function AddToWishlist(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez vous connecter d\'abord'
            ]);
        }
        
        // Récupérer l'ID de l'utilisateur connecté et l'ID de la propriété
        $user_id = Auth::user()->id;
        $property_id = $request->property_id;
        
        // Vérifier si la propriété existe déjà dans les favoris de l'utilisateur
        $exists = Favorite::where('user_id', $user_id)
                        ->where('property_id', $property_id)
                        ->first();
        
        // Si c'est juste une vérification (pour afficher l'état du bouton)
        if ($request->has('check_only') && $request->check_only) {
            return response()->json([
                'in_wishlist' => $exists ? true : false
            ]);
        }
        
        if ($exists) {
            // Si la propriété est déjà dans les favoris, la supprimer
            Favorite::where('user_id', $user_id)
                    ->where('property_id', $property_id)
                    ->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Propriété retirée des favoris'
            ]);
        } else {
            // Sinon, ajouter la propriété aux favoris
            Favorite::create([
                'user_id' => $user_id,
                'property_id' => $property_id
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Propriété ajoutée aux favoris'
            ]);
        }
    }
    
    /**
     * Supprime une propriété des favoris
     * 
     * @param int $id ID du favori à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function RemoveFromWishlist($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = Auth::user()->id;
        
        // Supprimer le favori
        Favorite::where('id', $id)
                ->where('user_id', $user_id)
                ->delete();
        
        $notification = [
            'message' => 'Propriété retirée des favoris',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
