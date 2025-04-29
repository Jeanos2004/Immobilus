<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyReview;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Stocke un nouvel avis pour une propriété
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreReview(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'message' => 'Veuillez vous connecter pour laisser un avis',
                'alert-type' => 'error'
            ]);
        }
        
        // Valider les données
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ], [
            'rating.required' => 'Veuillez attribuer une note',
            'rating.min' => 'La note minimale est de 1 étoile',
            'rating.max' => 'La note maximale est de 5 étoiles',
            'comment.required' => 'Veuillez laisser un commentaire',
            'comment.min' => 'Le commentaire doit contenir au moins 10 caractères',
            'comment.max' => 'Le commentaire ne doit pas dépasser 1000 caractères'
        ]);
        
        // Vérifier si l'utilisateur a déjà laissé un avis pour cette propriété
        $existingReview = PropertyReview::where('user_id', Auth::id())
                                        ->where('property_id', $request->property_id)
                                        ->first();
        
        if ($existingReview) {
            // Mettre à jour l'avis existant
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'updated_at' => Carbon::now()
            ]);
            
            $notification = [
                'message' => 'Votre avis a été mis à jour avec succès',
                'alert-type' => 'success'
            ];
        } else {
            // Créer un nouvel avis
            PropertyReview::create([
                'property_id' => $request->property_id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'pending' // Les avis doivent être approuvés par un administrateur
            ]);
            
            $notification = [
                'message' => 'Votre avis a été soumis avec succès et sera visible après modération',
                'alert-type' => 'success'
            ];
        }
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Affiche tous les avis pour l'administration
     * 
     * @return \Illuminate\View\View
     */
    public function AdminAllReviews()
    {
        // Récupérer tous les avis avec les relations
        $reviews = PropertyReview::with(['user', 'property'])
                                ->latest()
                                ->get();
        
        return view('backend.review.all_reviews', compact('reviews'));
    }
    
    /**
     * Change le statut d'un avis (approuver/rejeter)
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ChangeReviewStatus($id)
    {
        $review = PropertyReview::findOrFail($id);
        
        // Déterminer l'action en fonction de l'URL utilisée
        $routeName = request()->route()->getName();
        
        if ($routeName === 'review.approve') {
            $review->update([
                'status' => 'approved'
            ]);
            
            $notification = [
                'message' => 'Avis approuvé avec succès',
                'alert-type' => 'success'
            ];
        } else {
            $review->update([
                'status' => 'rejected'
            ]);
            
            $notification = [
                'message' => 'Avis rejeté avec succès',
                'alert-type' => 'success'
            ];
        }
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Supprime un avis
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteReview($id)
    {
        PropertyReview::findOrFail($id)->delete();
        
        $notification = [
            'message' => 'Avis supprimé avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
