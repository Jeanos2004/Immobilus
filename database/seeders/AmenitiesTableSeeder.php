<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenities;
use Carbon\Carbon;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Amenities::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Créer des aménités
        $amenities = [
            [
                'amenities_name' => 'Climatisation',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Balcon',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Salle de sport',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Piscine',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Internet haut débit',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Parking',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Ascenseur',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Sécurité 24/7',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Jardin',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Terrasse',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Lave-vaisselle',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Lave-linge',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Cuisine équipée',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Cheminée',
                'created_at' => Carbon::now(),
            ],
            [
                'amenities_name' => 'Animaux autorisés',
                'created_at' => Carbon::now(),
            ],
        ];
        
        // Insérer les aménités
        Amenities::insert($amenities);
    }
}
