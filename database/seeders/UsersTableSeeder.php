<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode remplit la table des utilisateurs avec des données factices.
     * Elle crée des comptes admin, agent et plusieurs utilisateurs réguliers.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Créer les utilisateurs de base (admin, agent, utilisateur standard)
        $baseUsers = [
            // Admin
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Agent
            [
                'name' => 'Agent',
                'username' => 'agent',
                'email' => 'agent@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'agent',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User principal
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Utilisateurs supplémentaires
            [
                'name' => 'Sophie Martin',
                'username' => 'sophie',
                'email' => 'sophie@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thomas Dubois',
                'username' => 'thomas',
                'email' => 'thomas@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emma Petit',
                'username' => 'emma',
                'email' => 'emma@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lucas Bernard',
                'username' => 'lucas',
                'email' => 'lucas@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Camille Rousseau',
                'username' => 'camille',
                'email' => 'camille@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Insérer les utilisateurs
        User::insert($baseUsers);
        
        // Créer un agent supplémentaire
        User::create([
            'name' => 'Marie Dupont',
            'username' => 'marie',
            'email' => 'marie@example.com',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Afficher un message de succès dans la console
        $this->command->info('Utilisateurs insérés avec succès!');
    }
}
