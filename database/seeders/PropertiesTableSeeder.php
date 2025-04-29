<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use App\Models\Amenities;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode remplit la table des propriétés avec des données factices.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider les tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Property::truncate();
        DB::table('property_amenities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Récupérer l'ID de l'agent pour associer les propriétés
        $agentId = User::where('role', 'agent')->first()->id;
        
        // Récupérer tous les types de propriétés pour les utiliser aléatoirement
        $propertyTypes = PropertyType::pluck('id')->toArray();
        
        // Récupérer toutes les aménités pour les associer aléatoirement
        $amenities = Amenities::pluck('id')->toArray();
        
        // Créer un tableau de propriétés factices
        $properties = [
            [
                'ptype_id' => $propertyTypes[0], // Appartement
                'agent_id' => $agentId,
                'property_name' => 'Appartement moderne au centre-ville',
                'property_slug' => Str::slug('Appartement moderne au centre-ville'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'vente',
                'lowest_price' => 250000,
                'max_price' => 280000,
                'property_thumbnail' => 'upload/property/thumbnail/1718537852.jpg',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'garage' => 1,
                'garage_size' => '1',
                'property_size' => '85',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '123 Rue de Paris',
                'city' => 'Paris',
                'state' => 'Île-de-France',
                'postal_code' => '75001',
                'neighborhood' => 'Quartier des Halles',
                'latitude' => '48.856614',
                'longitude' => '2.352222',
                'featured' => 1,
                'hot' => 1,
                'short_description' => 'Magnifique appartement rénové au cœur de Paris, proche de toutes commodités.',
                'long_description' => 'Ce superbe appartement entièrement rénové offre un espace de vie lumineux et moderne. Situé au 3ème étage d’un immeuble hausmannien avec ascenseur, il comprend un séjour spacieux, une cuisine équipée ouverte, deux chambres confortables, une salle de bain avec douche à l’italienne, et un WC séparé. Les prestations haut de gamme incluent parquet en chêne massif, double vitrage, chauffage central, et climatisation réversible. Idéalement situé à deux pas des commerces, restaurants, et transports en commun.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[1], // Maison
                'agent_id' => $agentId,
                'property_name' => 'Villa de luxe avec piscine',
                'property_slug' => Str::slug('Villa de luxe avec piscine'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'vente',
                'lowest_price' => 750000,
                'max_price' => 800000,
                'property_thumbnail' => 'upload/property/thumbnail/1718537853.jpg',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'garage' => 2,
                'garage_size' => '2',
                'property_size' => '220',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '45 Avenue des Pins',
                'city' => 'Nice',
                'state' => 'Provence-Alpes-Côte d\'Azur',
                'postal_code' => '06000',
                'neighborhood' => 'Mont Boron',
                'latitude' => '43.695949',
                'longitude' => '7.270789',
                'featured' => 1,
                'hot' => 1,
                'short_description' => 'Magnifique villa avec vue panoramique sur la mer Méditerranée.',
                'long_description' => 'Cette villa d’exception offre une vue imprenable sur la mer Méditerranée. Construite sur un terrain de 1200m², elle dispose d’un vaste séjour lumineux donnant sur une terrasse avec piscine à débordement, une cuisine américaine entièrement équipée, quatre chambres spacieuses dont une suite parentale avec dressing et salle de bain privée, deux salles d’eau supplémentaires, et un bureau. Le jardin paysager offre plusieurs espaces de détente et un pool house avec cuisine d’été. Garage pour deux véhicules et système de sécurité dernier cri.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[3], // Bureau
                'agent_id' => $agentId,
                'property_name' => 'Espace de bureau moderne',
                'property_slug' => Str::slug('Espace de bureau moderne'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'location',
                'lowest_price' => 2500,
                'max_price' => 2500,
                'property_thumbnail' => 'upload/property/thumbnail/1718537854.jpg',
                'bedrooms' => 0,
                'bathrooms' => 2,
                'garage' => 0,
                'garage_size' => '0',
                'property_size' => '150',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '78 Rue de la République',
                'city' => 'Lyon',
                'state' => 'Auvergne-Rhône-Alpes',
                'postal_code' => '69002',
                'neighborhood' => 'Presqu’île',
                'latitude' => '45.763420',
                'longitude' => '4.836010',
                'featured' => 0,
                'hot' => 0,
                'short_description' => 'Espace de bureau moderne et lumineux au cœur de Lyon.',
                'long_description' => 'Cet espace de bureau de 150m² offre un cadre de travail idéal pour les entreprises dynamiques. Situé dans un immeuble récent au cœur de Lyon, il comprend un espace ouvert pouvant accueillir jusqu’à 15 postes de travail, deux bureaux fermés, une salle de réunion, un espace détente avec kitchenette, et deux sanitaires. Entièrement câblé et équipé de la fibre optique, il bénéficie également d’une climatisation réversible et d’un contrôle d’accès sécurisé. Proche des transports en commun et de nombreux commerces et restaurants.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[2], // Villa
                'agent_id' => $agentId,
                'property_name' => 'Villa contemporaine avec jardin',
                'property_slug' => Str::slug('Villa contemporaine avec jardin'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'vente',
                'lowest_price' => 550000,
                'max_price' => 580000,
                'property_thumbnail' => 'upload/property/thumbnail/1718537855.jpg',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'garage' => 1,
                'garage_size' => '1',
                'property_size' => '180',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '15 Rue des Lilas',
                'city' => 'Bordeaux',
                'state' => 'Nouvelle-Aquitaine',
                'postal_code' => '33000',
                'neighborhood' => 'Caudéran',
                'latitude' => '44.837789',
                'longitude' => '-0.579180',
                'featured' => 1,
                'hot' => 0,
                'short_description' => 'Villa contemporaine avec grand jardin dans quartier résidentiel calme.',
                'long_description' => 'Cette villa contemporaine de 180m² offre un cadre de vie exceptionnel dans l’un des quartiers les plus recherchés de Bordeaux. Elle se compose d’un vaste séjour traversant baigné de lumière, d’une cuisine ouverte entièrement équipée, de trois chambres dont une suite parentale avec dressing et salle d’eau, d’une salle de bain familiale, et d’un bureau. Le jardin paysager de 600m² offre une terrasse en bois exotique et plusieurs espaces de détente. Garage attenant et stationnement extérieur pour deux véhicules. Prestations haut de gamme incluant chauffage au sol, domotique, et panneaux solaires.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[0], // Appartement
                'agent_id' => $agentId,
                'property_name' => 'Studio rénové proche université',
                'property_slug' => Str::slug('Studio rénové proche université'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'location',
                'lowest_price' => 550,
                'max_price' => 550,
                'property_thumbnail' => 'upload/property/thumbnail/1718537856.jpg',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage' => 0,
                'garage_size' => '0',
                'property_size' => '25',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '8 Rue des Étudiants',
                'city' => 'Toulouse',
                'state' => 'Occitanie',
                'postal_code' => '31000',
                'neighborhood' => 'Rangueil',
                'latitude' => '43.604652',
                'longitude' => '1.444209',
                'featured' => 0,
                'hot' => 1,
                'short_description' => 'Studio rénové idéal pour étudiant, proche de l’université et des commerces.',
                'long_description' => 'Ce studio de 25m² entièrement rénové offre un espace de vie fonctionnel et agréable. Il comprend une pièce principale lumineuse avec coin nuit, une kitchenette équipée (plaques, réfrigérateur, micro-ondes), et une salle d’eau avec douche et WC. Situé au 2ème étage d’une résidence sécurisée avec ascenseur, il bénéficie d’une excellente isolation thermique et phonique. À 5 minutes à pied de l’université, des commerces et des transports en commun. Idéal pour étudiant ou jeune actif.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[4], // Local commercial
                'agent_id' => $agentId,
                'property_name' => 'Local commercial en centre-ville',
                'property_slug' => Str::slug('Local commercial en centre-ville'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'location',
                'lowest_price' => 1800,
                'max_price' => 1800,
                'property_thumbnail' => 'upload/property/thumbnail/1718537857.jpg',
                'bedrooms' => 0,
                'bathrooms' => 1,
                'garage' => 0,
                'garage_size' => '0',
                'property_size' => '90',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '25 Rue du Commerce',
                'city' => 'Lille',
                'state' => 'Hauts-de-France',
                'postal_code' => '59000',
                'neighborhood' => 'Centre',
                'latitude' => '50.637222',
                'longitude' => '3.063333',
                'featured' => 1,
                'hot' => 0,
                'short_description' => 'Local commercial idéalement situé en centre-ville avec forte affluence.',
                'long_description' => 'Ce local commercial de 90m² bénéficie d’un emplacement privilégié dans l’une des rues les plus fréquentées du centre-ville de Lille. Il se compose d’un espace de vente de 70m² avec vitrine de 6m linéaires, d’une réserve de 15m², et d’un sanitaire. Entièrement rénové, il dispose d’une climatisation réversible, d’un rideau métallique électrique, et d’un système d’alarme. Tous commerces autorisés sauf restauration avec extraction. Fort potentiel commercial grâce à l’important flux piétonnier et la proximité des transports en commun.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[5], // Terrain
                'agent_id' => $agentId,
                'property_name' => 'Terrain constructible avec vue',
                'property_slug' => Str::slug('Terrain constructible avec vue'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'vente',
                'lowest_price' => 180000,
                'max_price' => 180000,
                'property_thumbnail' => 'upload/property/thumbnail/1718537858.jpg',
                'bedrooms' => 0,
                'bathrooms' => 0,
                'garage' => 0,
                'garage_size' => '0',
                'property_size' => '1200',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => 'Route des Collines',
                'city' => 'Aix-en-Provence',
                'state' => 'Provence-Alpes-Côte d\'Azur',
                'postal_code' => '13100',
                'neighborhood' => 'Les Platanes',
                'latitude' => '43.529742',
                'longitude' => '5.447427',
                'featured' => 0,
                'hot' => 1,
                'short_description' => 'Magnifique terrain constructible de 1200m² avec vue panoramique.',
                'long_description' => 'Ce terrain constructible de 1200m² offre une vue panoramique exceptionnelle sur la campagne environnante. Situé dans un quartier résidentiel recherché d’Aix-en-Provence, il bénéficie d’une exposition sud-ouest idéale et d’un environnement calme et verdoyant. Le terrain est viabilisé (eau, électricité, tout-à-l’égout) et dispose d’un certificat d’urbanisme positif permettant la construction d’une villa jusqu’à 250m² de surface habitable. Accès facile et proximité des commodités (10 minutes du centre-ville).',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'ptype_id' => $propertyTypes[7], // Loft
                'agent_id' => $agentId,
                'property_name' => 'Loft industriel rénové',
                'property_slug' => Str::slug('Loft industriel rénové'),
                'property_code' => 'PC'.mt_rand(100000, 999999),
                'property_status' => 'vente',
                'lowest_price' => 420000,
                'max_price' => 450000,
                'property_thumbnail' => 'upload/property/thumbnail/1718537859.jpg',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'garage' => 1,
                'garage_size' => '1',
                'property_size' => '160',
                'property_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'address' => '12 Rue des Usines',
                'city' => 'Nantes',
                'state' => 'Pays de la Loire',
                'postal_code' => '44000',
                'neighborhood' => 'Île de Nantes',
                'latitude' => '47.218371',
                'longitude' => '-1.553621',
                'featured' => 1,
                'hot' => 1,
                'short_description' => 'Magnifique loft dans une ancienne usine réhabilitée avec goût.',
                'long_description' => 'Ce loft d’exception de 160m² est situé dans une ancienne usine textile entièrement réhabilitée. Il offre un vaste espace de vie de plus de 80m² avec une hauteur sous plafond de 4m et de grandes baies vitrées industrielles, une cuisine ouverte entièrement équipée, deux chambres en mezzanine dont une suite parentale avec dressing et salle de bain, une seconde salle d’eau, et un bureau. Les éléments d’origine (poutres métalliques, briques apparentes, sol en béton ciré) ont été conservés et mis en valeur. Garage privé en sous-sol et accès sécurisé. Quartier en pleine mutation offrant de nombreux commerces, restaurants et espaces culturels.',
                'status' => 1,
                'created_at' => Carbon::now(),
            ],
        ];
        
        // Insérer les propriétés
        foreach ($properties as $property) {
            // Insérer la propriété
            $propertyId = Property::insertGetId($property);
            
            // Associer des aménités aléatoires à chaque propriété
            $randomAmenities = array_rand(array_flip($amenities), mt_rand(3, 8));
            foreach ($randomAmenities as $amenityId) {
                DB::table('property_amenities')->insert([
                    'property_id' => $propertyId,
                    'amenities_id' => $amenityId,
                ]);
            }
        }
    }
}
