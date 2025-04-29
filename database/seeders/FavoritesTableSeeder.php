<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode remplit la table des favoris avec des données factices.
     * Elle simule des utilisateurs qui ont ajouté des propriétés à leurs favoris.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Favorite::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Récupérer tous les utilisateurs réguliers (non admin, non agent)
        $users = User::where('role', 'user')->get();
        
        // Si aucun utilisateur régulier n'existe, créer quelques utilisateurs supplémentaires
        if ($users->count() < 3) {
            // Créer quelques utilisateurs supplémentaires pour les tests
            $newUsers = [
                [
                    'name' => 'Sophie Martin',
                    'username' => 'sophie',
                    'email' => 'sophie@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'user',
                    'status' => 'active',
                ],
                [
                    'name' => 'Thomas Dubois',
                    'username' => 'thomas',
                    'email' => 'thomas@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'user',
                    'status' => 'active',
                ],
                [
                    'name' => 'Emma Petit',
                    'username' => 'emma',
                    'email' => 'emma@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'user',
                    'status' => 'active',
                ],
            ];
            
            foreach ($newUsers as $newUser) {
                User::create($newUser);
            }
            
            // Récupérer à nouveau les utilisateurs après en avoir ajouté
            $users = User::where('role', 'user')->get();
        }
        
        // Récupérer toutes les propriétés
        $properties = Property::all();
        
        // Pour chaque utilisateur, ajouter quelques propriétés en favoris
        foreach ($users as $user) {
            // Nombre aléatoire de favoris pour cet utilisateur (entre 2 et 5)
            $numFavorites = mt_rand(2, 5);
            
            // Sélectionner des propriétés aléatoires pour cet utilisateur
            $randomProperties = $properties->random($numFavorites);
            
            // Ajouter chaque propriété aux favoris de l'utilisateur
            foreach ($randomProperties as $property) {
                Favorite::create([
                    'user_id' => $user->id,
                    'property_id' => $property->id,
                    'created_at' => Carbon::now()->subDays(mt_rand(1, 30)), // Date aléatoire dans les 30 derniers jours
                ]);
            }
        }
        
        // Afficher un message de succès dans la console
        $this->command->info('Favoris insérés avec succès!');
    }
}
