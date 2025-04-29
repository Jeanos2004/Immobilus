<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PropertyImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode remplit la table des images de propriétés avec des données factices.
     * Chaque propriété aura entre 3 et 6 images associées.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PropertyImage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Récupérer toutes les propriétés pour leur associer des images
        $properties = Property::all();
        
        // Tableau des noms de fichiers d'images factices
        // Dans un environnement réel, ces fichiers seraient présents dans le dossier upload/property/multi-image/
        $imageFiles = [
            '1718537860.jpg',
            '1718537861.jpg',
            '1718537862.jpg',
            '1718537863.jpg',
            '1718537864.jpg',
            '1718537865.jpg',
            '1718537866.jpg',
            '1718537867.jpg',
            '1718537868.jpg',
            '1718537869.jpg',
            '1718537870.jpg',
            '1718537871.jpg',
            '1718537872.jpg',
            '1718537873.jpg',
            '1718537874.jpg',
        ];
        
        // Pour chaque propriété, ajouter entre 3 et 6 images
        foreach ($properties as $property) {
            // Déterminer le nombre d'images à ajouter pour cette propriété (entre 3 et 6)
            $numImages = mt_rand(3, 6);
            
            // Mélanger le tableau d'images pour obtenir des sélections aléatoires
            shuffle($imageFiles);
            
            // Ajouter les images à la propriété
            for ($i = 0; $i < $numImages; $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'photo_name' => 'upload/property/multi-image/' . $imageFiles[$i],
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        
        // Afficher un message de succès dans la console
        $this->command->info('Images de propriétés insérées avec succès!');
    }
}
