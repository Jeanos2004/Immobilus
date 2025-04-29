<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Ce seeder génère des rendez-vous factices pour tester le système de rendez-vous
     * et de notifications de l'application.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère avant le truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Vider la table des rendez-vous
        Appointment::truncate();
        
        // Réactiver les contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Récupérer les utilisateurs avec le rôle 'user'
        $users = User::where('role', 'user')->get();
        
        // Récupérer les agents
        $agents = User::where('role', 'agent')->get();
        
        // Récupérer les propriétés
        $properties = Property::all();
        
        // Si nous n'avons pas assez d'utilisateurs, d'agents ou de propriétés, ne rien faire
        if ($users->isEmpty() || $agents->isEmpty() || $properties->isEmpty()) {
            $this->command->info('Impossible de générer des rendez-vous : pas assez d\'utilisateurs, d\'agents ou de propriétés.');
            return;
        }
        
        // Statuts possibles pour les rendez-vous
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        
        // Générer 50 rendez-vous aléatoires
        $appointmentsData = [];
        
        for ($i = 0; $i < 50; $i++) {
            // Sélectionner un utilisateur, un agent et une propriété aléatoires
            $user = $users->random();
            $agent = $agents->random();
            $property = $properties->random();
            
            // Générer une date aléatoire entre aujourd'hui et dans 30 jours
            $appointmentDate = Carbon::now()->addDays(rand(1, 30))->addHours(rand(9, 17));
            
            // Pour les rendez-vous dans le passé (pour tester les statuts completed)
            if (rand(0, 1) && $i < 15) {
                $appointmentDate = Carbon::now()->subDays(rand(1, 10))->addHours(rand(9, 17));
            }
            
            // Sélectionner un statut aléatoire
            // Les rendez-vous dans le futur sont plus susceptibles d'être en attente ou confirmés
            // Les rendez-vous dans le passé sont plus susceptibles d'être terminés ou annulés
            if ($appointmentDate->isFuture()) {
                $status = $statuses[rand(0, 1)]; // pending ou confirmed
            } else {
                $status = $statuses[rand(2, 3)]; // cancelled ou completed
            }
            
            // Messages possibles pour les rendez-vous
            $messages = [
                'Je souhaiterais visiter cette propriété dès que possible.',
                'Cette propriété correspond à mes critères, je voudrais la visiter.',
                'Bonjour, je suis intéressé(e) par cette propriété et j\'aimerais la visiter.',
                'Est-ce que ce créneau vous convient pour une visite ?',
                'Je suis disponible à cette date pour visiter la propriété.',
                'Je cherche un bien de ce type depuis longtemps, j\'aimerais le visiter.',
                'Cette propriété semble parfaite pour ma famille, pouvons-nous la visiter ?',
                'Je souhaite visiter ce bien pour voir s\'il correspond à mes attentes.',
                'Bonjour, je suis très intéressé(e) par ce bien, est-ce possible de le visiter ?',
                'Cette propriété me plaît beaucoup, j\'aimerais la voir en personne.'
            ];
            
            // Créer le rendez-vous
            $appointmentsData[] = [
                'user_id' => $user->id,
                'agent_id' => $agent->id,
                'property_id' => $property->id,
                'appointment_date' => $appointmentDate,
                'message' => $messages[array_rand($messages)],
                'status' => $status,
                'created_at' => Carbon::now()->subDays(rand(1, 15)),
                'updated_at' => Carbon::now()->subDays(rand(0, 5))
            ];
        }
        
        // Insérer tous les rendez-vous d'un coup
        Appointment::insert($appointmentsData);
        
        $this->command->info('50 rendez-vous factices ont été créés avec succès.');
    }
}
