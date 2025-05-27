<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentPlan;

class PaymentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les plans existants pour éviter les doublons
        PaymentPlan::truncate();
        
        // Créer les plans de paiement par défaut
        $plans = [
            [
                'name' => 'Visite Simple',
                'description' => 'Réservez une visite de la propriété avec un agent immobilier.',
                'price' => 50.00,
                'duration' => 'once',
                'duration_value' => 1,
                'status' => true,
                'featured' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'Réservation Standard',
                'description' => 'Réservez la propriété pour une période de 3 jours avec possibilité de remboursement.',
                'price' => 250.00,
                'duration' => 'days',
                'duration_value' => 3,
                'status' => true,
                'featured' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Acompte Premium',
                'description' => 'Versez un acompte pour sécuriser la propriété pendant 7 jours avec services exclusifs.',
                'price' => 500.00,
                'duration' => 'days',
                'duration_value' => 7,
                'status' => true,
                'featured' => false,
                'sort_order' => 3
            ],
            [
                'name' => 'Option d\'Achat',
                'description' => 'Sécurisez une option d\'achat exclusive sur la propriété pendant 30 jours.',
                'price' => 1000.00,
                'duration' => 'days',
                'duration_value' => 30,
                'status' => true,
                'featured' => false,
                'sort_order' => 4
            ],
        ];
        
        // Insérer les plans dans la base de données
        foreach ($plans as $plan) {
            PaymentPlan::create($plan);
        }
    }
}
