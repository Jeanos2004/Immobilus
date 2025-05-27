<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Cette méthode appelle tous les seeders dans l'ordre approprié
     * pour remplir la base de données avec des données factices.
     */
    public function run(): void
    {
        // Ordre d'exécution important pour respecter les dépendances entre tables
        $this->call([
            // 1. Utilisateurs (admin, agent, utilisateurs réguliers)
            UsersTableSeeder::class,
            
            // 2. Types de propriétés et aménités (tables de référence)
            PropertyTypesTableSeeder::class,
            AmenitiesTableSeeder::class,
            
            // 3. Propriétés (dépend des utilisateurs et des types de propriétés)
            PropertiesTableSeeder::class,
            
            // 4. Images de propriétés (dépend des propriétés)
            PropertyImagesTableSeeder::class,
            
            // 5. Plans de paiement
            PaymentPlanSeeder::class,
            
            // 5. Témoignages clients
            TestimonialsSeeder::class,
            
            // 5. Favoris et avis (dépendent des propriétés et des utilisateurs)
            FavoritesTableSeeder::class,
            PropertyReviewsTableSeeder::class,
            
            // 6. Messages (dépendent des propriétés et des utilisateurs)
            MessagesTableSeeder::class,
            
            // 7. Rendez-vous (dépendent des propriétés et des utilisateurs)
            AppointmentsTableSeeder::class,
        ]);
    }
}
