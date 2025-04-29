<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertyType;
use Carbon\Carbon;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PropertyType::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Créer des types de propriétés
        $propertyTypes = [
            [
                'type_name' => 'Appartement',
                'type_icon' => 'fas fa-building',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Maison',
                'type_icon' => 'fas fa-home',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Villa',
                'type_icon' => 'fas fa-hotel',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Bureau',
                'type_icon' => 'fas fa-briefcase',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Local commercial',
                'type_icon' => 'fas fa-store',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Terrain',
                'type_icon' => 'fas fa-map',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Parking',
                'type_icon' => 'fas fa-parking',
                'created_at' => Carbon::now(),
            ],
            [
                'type_name' => 'Loft',
                'type_icon' => 'fas fa-warehouse',
                'created_at' => Carbon::now(),
            ],
        ];
        
        // Insérer les types de propriétés
        PropertyType::insert($propertyTypes);
    }
}
