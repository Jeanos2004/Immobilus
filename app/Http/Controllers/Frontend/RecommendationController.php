<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Favorite;
use App\Models\PropertyType;
use App\Models\PropertyReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RecommendationController extends Controller
{
    /**
     * Affiche la page principale des recommandations pour l'utilisateur connecté
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            $notification = array(
                'message' => 'Vous devez être connecté pour voir vos recommandations',
                'alert-type' => 'warning'
            );
            return redirect()->route('login')->with($notification);
        }

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer les différents types de recommandations
        $favoriteBasedRecommendations = $this->getFavoriteBasedRecommendations($user->id, 4);
        $viewHistoryRecommendations = $this->getViewHistoryRecommendations($user->id, 4);
        $popularProperties = $this->getPopularProperties(4);
        $similarUserRecommendations = $this->getSimilarUserRecommendations($user->id, 4);

        return view('frontend.recommendations.index', compact(
            'favoriteBasedRecommendations',
            'viewHistoryRecommendations',
            'popularProperties',
            'similarUserRecommendations'
        ));
    }

    /**
     * Génère des recommandations basées sur les favoris de l'utilisateur
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getFavoriteBasedRecommendations($userId, $limit = 4)
    {
        // Récupérer les types de propriétés que l'utilisateur a mis en favori
        $favoriteTypes = Favorite::join('properties', 'favorites.property_id', '=', 'properties.id')
            ->where('favorites.user_id', $userId)
            ->pluck('properties.ptype_id')
            ->unique();

        // Si l'utilisateur n'a pas de favoris, retourner des propriétés aléatoires
        if ($favoriteTypes->isEmpty()) {
            return Property::where('status', 1)
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        }

        // Récupérer les propriétés similaires basées sur les types favoris
        // Exclure les propriétés déjà en favori
        $favoritedPropertyIds = Favorite::where('user_id', $userId)->pluck('property_id');

        return Property::whereIn('ptype_id', $favoriteTypes)
            ->where('status', 1)
            ->whereNotIn('id', $favoritedPropertyIds)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Génère des recommandations basées sur l'historique de navigation de l'utilisateur
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getViewHistoryRecommendations($userId, $limit = 4)
    {
        // Récupérer l'historique de navigation depuis la session
        $viewHistory = Session::get('viewed_properties', []);

        // Si l'utilisateur n'a pas d'historique, retourner des propriétés aléatoires
        if (empty($viewHistory)) {
            return Property::where('status', 1)
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        }

        // Récupérer les types de propriétés vues
        $viewedTypes = Property::whereIn('id', array_keys($viewHistory))
            ->pluck('ptype_id')
            ->unique();

        // Récupérer les propriétés similaires basées sur les types vus
        // Exclure les propriétés déjà vues
        return Property::whereIn('ptype_id', $viewedTypes)
            ->where('status', 1)
            ->whereNotIn('id', array_keys($viewHistory))
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les propriétés les plus populaires (basé sur les vues, favoris et avis)
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPopularProperties($limit = 4)
    {
        // Calculer la popularité basée sur le nombre de favoris et d'avis
        $popularProperties = DB::table('properties')
            ->leftJoin('favorites', 'properties.id', '=', 'favorites.property_id')
            ->leftJoin('property_reviews', 'properties.id', '=', 'property_reviews.property_id')
            ->select(
                'properties.id',
                DB::raw('COUNT(DISTINCT favorites.id) as favorite_count'),
                DB::raw('COUNT(DISTINCT property_reviews.id) as review_count'),
                DB::raw('AVG(property_reviews.rating) as avg_rating')
            )
            ->where('properties.status', 1)
            ->groupBy('properties.id')
            ->orderByRaw('(COUNT(DISTINCT favorites.id) * 2 + COUNT(DISTINCT property_reviews.id) + COALESCE(AVG(property_reviews.rating), 0)) DESC')
            ->limit($limit)
            ->pluck('properties.id');

        // Récupérer les propriétés complètes
        return Property::whereIn('id', $popularProperties)
            ->where('status', 1)
            ->get();
    }

    /**
     * Génère des recommandations basées sur les préférences d'utilisateurs similaires
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getSimilarUserRecommendations($userId, $limit = 4)
    {
        // Récupérer les favoris de l'utilisateur actuel
        $userFavorites = Favorite::where('user_id', $userId)->pluck('property_id');

        // Si l'utilisateur n'a pas de favoris, retourner des propriétés aléatoires
        if ($userFavorites->isEmpty()) {
            return Property::where('status', 1)
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        }

        // Trouver des utilisateurs qui ont des favoris similaires
        $similarUsers = Favorite::whereIn('property_id', $userFavorites)
            ->where('user_id', '!=', $userId)
            ->select('user_id', DB::raw('COUNT(*) as common_favorites'))
            ->groupBy('user_id')
            ->orderBy('common_favorites', 'desc')
            ->limit(5)
            ->pluck('user_id');

        // Si aucun utilisateur similaire n'est trouvé, retourner des propriétés aléatoires
        if ($similarUsers->isEmpty()) {
            return Property::where('status', 1)
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        }

        // Récupérer les favoris des utilisateurs similaires, en excluant ceux déjà favoris par l'utilisateur actuel
        $recommendedPropertyIds = Favorite::whereIn('user_id', $similarUsers)
            ->whereNotIn('property_id', $userFavorites)
            ->select('property_id', DB::raw('COUNT(*) as favorite_count'))
            ->groupBy('property_id')
            ->orderBy('favorite_count', 'desc')
            ->limit($limit)
            ->pluck('property_id');

        // Récupérer les propriétés complètes
        return Property::whereIn('id', $recommendedPropertyIds)
            ->where('status', 1)
            ->get();
    }

    /**
     * Enregistre une propriété dans l'historique de navigation de l'utilisateur
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trackPropertyView(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id'
        ]);

        $propertyId = $request->property_id;
        
        // Récupérer l'historique de navigation existant
        $viewHistory = Session::get('viewed_properties', []);
        
        // Ajouter la propriété à l'historique avec un timestamp
        $viewHistory[$propertyId] = time();
        
        // Limiter l'historique aux 20 dernières propriétés vues
        if (count($viewHistory) > 20) {
            // Trier par timestamp (le plus récent d'abord)
            arsort($viewHistory);
            // Garder seulement les 20 premiers
            $viewHistory = array_slice($viewHistory, 0, 20, true);
        }
        
        // Sauvegarder l'historique mis à jour dans la session
        Session::put('viewed_properties', $viewHistory);
        
        return response()->json(['success' => true]);
    }
}
