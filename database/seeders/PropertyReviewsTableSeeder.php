<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertyReview;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PropertyReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode remplit la table des avis sur les propriétés avec des données factices.
     * Elle simule des utilisateurs qui ont laissé des évaluations sur les propriétés.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PropertyReview::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Récupérer tous les utilisateurs réguliers (non admin, non agent)
        $users = User::where('role', 'user')->get();
        
        // Récupérer toutes les propriétés
        $properties = Property::all();
        
        // Tableau de commentaires positifs possibles
        $positiveComments = [
            "Superbe propriété avec une vue incroyable. L'agent a été très professionnel et disponible.",
            "Emplacement idéal, proche de toutes les commodités. Je recommande vivement!",
            "Excellent rapport qualité-prix. Les photos correspondent parfaitement à la réalité.",
            "Propriété très bien entretenue et rénovée avec goût. Je suis totalement satisfait.",
            "Visite très agréable, l'agent a répondu à toutes mes questions. Très bonne expérience.",
            "Espace lumineux et bien agencé. La description était parfaitement exacte.",
            "Quartier calme et sécurisé, idéal pour une famille. Je recommande cette propriété.",
            "Très satisfait de ma visite. Les finitions sont de grande qualité.",
        ];
        
        // Tableau de commentaires mitigés possibles
        $mixedComments = [
            "Bonne propriété dans l'ensemble, mais quelques travaux de rafraîchissement seraient nécessaires.",
            "Emplacement intéressant, mais un peu bruyant aux heures de pointe.",
            "Bon potentiel, mais le prix semble un peu élevé par rapport aux prestations offertes.",
            "La propriété est agréable, mais les photos la font paraître plus spacieuse qu'elle ne l'est réellement.",
            "Visite correcte, mais l'agent n'était pas très réactif à mes questions.",
            "Propriété conforme à la description, mais l'isolation phonique laisse à désirer.",
        ];
        
        // Tableau de commentaires négatifs possibles
        $negativeComments = [
            "Déçu par cette propriété. L'état réel ne correspond pas du tout aux photos.",
            "Trop cher pour ce qui est proposé. Plusieurs défauts non mentionnés dans l'annonce.",
            "Mauvaise expérience. L'agent était en retard et peu professionnel.",
            "Propriété mal entretenue et nécessitant beaucoup plus de travaux que mentionné.",
        ];
        
        // Pour chaque propriété, ajouter entre 0 et 4 avis
        foreach ($properties as $property) {
            // Déterminer le nombre d'avis pour cette propriété (entre 0 et 4)
            $numReviews = mt_rand(0, 4);
            
            // Si le nombre d'avis est supérieur au nombre d'utilisateurs, ajuster
            $numReviews = min($numReviews, $users->count());
            
            // Sélectionner des utilisateurs aléatoires pour cette propriété
            $randomUsers = $users->random($numReviews);
            
            // Pour chaque utilisateur sélectionné, créer un avis
            foreach ($randomUsers as $user) {
                // Déterminer la note (entre 1 et 5)
                $rating = mt_rand(1, 5);
                
                // Sélectionner un commentaire en fonction de la note
                if ($rating >= 4) {
                    // Note élevée (4-5) = commentaire positif
                    $comment = $positiveComments[array_rand($positiveComments)];
                } elseif ($rating >= 2) {
                    // Note moyenne (2-3) = commentaire mitigé
                    $comment = $mixedComments[array_rand($mixedComments)];
                } else {
                    // Note basse (1) = commentaire négatif
                    $comment = $negativeComments[array_rand($negativeComments)];
                }
                
                // Créer l'avis
                PropertyReview::create([
                    'property_id' => $property->id,
                    'user_id' => $user->id,
                    'comment' => $comment,
                    'rating' => $rating,
                    'status' => mt_rand(0, 10) > 2 ? 'approved' : 'pending', // 80% des avis sont approuvés, 20% en attente
                    'created_at' => Carbon::now()->subDays(mt_rand(1, 60)), // Date aléatoire dans les 60 derniers jours
                ]);
            }
        }
        
        // Afficher un message de succès dans la console
        $this->command->info('Avis sur les propriétés insérés avec succès!');
    }
}
