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

    /**
     * Enregistre une réponse à un avis
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreReviewReply(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'message' => 'Veuillez vous connecter pour répondre à un avis',
                'alert-type' => 'error'
            ]);
        }
        
        // Vérifier si l'utilisateur est un agent ou un administrateur
        if (!in_array(Auth::user()->role, ['admin', 'agent'])) {
            return redirect()->back()->with([
                'message' => 'Seuls les agents et administrateurs peuvent répondre aux avis',
                'alert-type' => 'error'
            ]);
        }
        
        // Valider les données
        $request->validate([
            'review_id' => 'required|exists:property_reviews,id',
            'reply' => 'required|string|min:10|max:1000'
        ], [
            'reply.required' => 'Veuillez saisir une réponse',
            'reply.min' => 'La réponse doit contenir au moins 10 caractères',
            'reply.max' => 'La réponse ne doit pas dépasser 1000 caractères'
        ]);
        
        // Créer la réponse
        ReviewReply::create([
            'review_id' => $request->review_id,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
            'user_type' => Auth::user()->role,
            'is_public' => true
        ]);
        
        $notification = [
            'message' => 'Votre réponse a été publiée avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }

    /**
     * Supprime une réponse à un avis
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteReviewReply($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $reply = ReviewReply::findOrFail($id);
        
        // Vérifier si l'utilisateur est autorisé à supprimer cette réponse
        if (Auth::id() != $reply->user_id && Auth::user()->role != 'admin') {
            return redirect()->back()->with([
                'message' => 'Vous n\'avez pas l\'autorisation de supprimer cette réponse',
                'alert-type' => 'error'
            ]);
        }
        
        $reply->delete();
        
        $notification = [
            'message' => 'Réponse supprimée avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }

    /**
     * Enregistre un vote sur un avis (utile ou non utile)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function VoteReview(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez vous connecter pour voter',
                'redirect' => route('login')
            ]);
        }
        
        // Valider les données
        $request->validate([
            'review_id' => 'required|exists:property_reviews,id',
            'is_helpful' => 'required|boolean'
        ]);
        
        // Vérifier si l'utilisateur a déjà voté pour cet avis
        $existingVote = ReviewVote::where('user_id', Auth::id())
                                ->where('review_id', $request->review_id)
                                ->first();
        
        if ($existingVote) {
            // Mettre à jour le vote existant
            $existingVote->update([
                'is_helpful' => $request->is_helpful
            ]);
            
            $message = 'Votre vote a été mis à jour';
        } else {
            // Créer un nouveau vote
            ReviewVote::create([
                'review_id' => $request->review_id,
                'user_id' => Auth::id(),
                'is_helpful' => $request->is_helpful
            ]);
            
            $message = 'Merci pour votre vote';
        }
        
        // Récupérer les nouveaux compteurs de votes
        $review = PropertyReview::find($request->review_id);
        $helpfulCount = $review->helpful_votes_count;
        $unhelpfulCount = $review->unhelpful_votes_count;
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'helpfulCount' => $helpfulCount,
            'unhelpfulCount' => $unhelpfulCount
        ]);
    }

    /**
     * Signale un avis comme inapproprié
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ReportReview(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'message' => 'Veuillez vous connecter pour signaler un avis',
                'alert-type' => 'error'
            ]);
        }
        
        // Valider les données
        $request->validate([
            'review_id' => 'required|exists:property_reviews,id',
            'reason' => 'required|in:spam,offensive,inappropriate,fake,other',
            'details' => 'nullable|string|max:1000'
        ]);
        
        // Vérifier si l'utilisateur a déjà signalé cet avis
        $existingReport = ReviewReport::where('user_id', Auth::id())
                                    ->where('review_id', $request->review_id)
                                    ->first();
        
        if ($existingReport) {
            return redirect()->back()->with([
                'message' => 'Vous avez déjà signalé cet avis',
                'alert-type' => 'info'
            ]);
        }
        
        // Créer le signalement
        ReviewReport::create([
            'review_id' => $request->review_id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'details' => $request->details,
            'status' => 'pending'
        ]);
        
        $notification = [
            'message' => 'Merci pour votre signalement. Il sera examiné par notre équipe.',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }

    /**
     * Affiche tous les signalements d'avis pour l'administration
     * 
     * @return \Illuminate\View\View
     */
    public function AdminAllReports()
    {
        // Récupérer tous les signalements avec les relations
        $reports = ReviewReport::with(['user', 'review', 'review.user', 'review.property'])
                            ->latest()
                            ->get();
        
        return view('backend.review.all_reports', compact('reports'));
    }

    /**
     * Change le statut d'un signalement (examiné/rejeté)
     * 
     * @param int $id
     * @param string $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ChangeReportStatus($id, $status)
    {
        $report = ReviewReport::findOrFail($id);
        
        if (!in_array($status, ['reviewed', 'dismissed'])) {
            return redirect()->back()->with([
                'message' => 'Statut invalide',
                'alert-type' => 'error'
            ]);
        }
        
        $report->update([
            'status' => $status,
            'admin_notes' => request('admin_notes')
        ]);
        
        $notification = [
            'message' => 'Statut du signalement mis à jour avec succès',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
    }
}
