<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cette méthode remplit la table des messages avec des données factices.
     * Elle simule des conversations entre utilisateurs et agents concernant des propriétés.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère et vider la table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Message::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Récupérer tous les utilisateurs réguliers (non admin, non agent)
        $users = User::where('role', 'user')->get();
        
        // Récupérer l'agent
        $agent = User::where('role', 'agent')->first();
        
        // Récupérer toutes les propriétés
        $properties = Property::all();
        
        // Tableau de sujets possibles pour les messages initiaux
        $subjects = [
            "Demande d'information sur la propriété",
            "Disponibilité pour une visite",
            "Question sur le prix",
            "Renseignements supplémentaires",
            "Intéressé par cette propriété",
            "Possibilité de négociation",
            "Détails sur le quartier",
        ];
        
        // Tableau de messages initiaux possibles (de l'utilisateur à l'agent)
        $initialMessages = [
            "Bonjour, je suis intéressé(e) par cette propriété et j'aimerais avoir plus d'informations. Est-elle toujours disponible ? Quand serait-il possible de la visiter ?",
            "Bonjour, cette propriété a retenu mon attention. Pourriez-vous me donner plus de détails sur l'état général et les éventuels travaux à prévoir ? Merci d'avance.",
            "Bonjour, je souhaiterais savoir si le prix de cette propriété est négociable et quels sont les frais annexes à prévoir (copropriété, taxes, etc.). Merci pour votre réponse.",
            "Bonjour, je suis très intéressé(e) par cette propriété et j'aimerais organiser une visite dès que possible. Quelles sont vos disponibilités cette semaine ? Merci.",
            "Bonjour, pourriez-vous me donner plus d'informations sur le quartier ? Notamment concernant les commerces à proximité, les écoles et les transports en commun. Merci beaucoup.",
            "Bonjour, cette propriété correspond exactement à ce que je recherche. Avant d'organiser une visite, j'aurais quelques questions : la propriété est-elle équipée d'un système d'alarme ? Y a-t-il des travaux prévus dans la copropriété ?",
        ];
        
        // Tableau de réponses possibles (de l'agent à l'utilisateur)
        $agentResponses = [
            "Bonjour, merci pour votre intérêt ! La propriété est effectivement toujours disponible. Je peux vous proposer une visite cette semaine, jeudi ou vendredi après-midi. Quelle date vous conviendrait le mieux ?",
            "Bonjour, je vous remercie pour votre message. La propriété est en excellent état, elle a été rénovée il y a moins de 5 ans (isolation, électricité, plomberie). Aucun travail majeur n'est à prévoir dans l'immédiat. N'hésitez pas si vous avez d'autres questions.",
            "Bonjour, concernant le prix, il y a une petite marge de négociation possible. Les charges de copropriété s'élèvent à environ 120€/mois et la taxe foncière est de 950€/an. Je reste à votre disposition pour toute information complémentaire.",
            "Bonjour et merci pour votre intérêt ! Je serais disponible pour vous faire visiter la propriété mardi à 14h ou mercredi à 10h. Dites-moi ce qui vous conviendrait le mieux. Au plaisir de vous rencontrer !",
            "Bonjour, le quartier est très bien desservi avec une station de métro à 5 minutes à pied, plusieurs lignes de bus, et un centre commercial à proximité. Il y a une école maternelle et primaire à moins de 500m, et un collège à 10 minutes. C'est un quartier calme et familial. N'hésitez pas si vous avez d'autres questions !",
            "Bonjour, merci pour votre message ! La propriété dispose effectivement d'un système d'alarme récent. Concernant la copropriété, le ravalement de façade a été fait l'année dernière et aucun gros travaux n'est prévu dans les 5 prochaines années. Quand souhaiteriez-vous visiter ?",
        ];
        
        // Tableau de réponses de suivi possibles (de l'utilisateur à l'agent)
        $userFollowUps = [
            "Merci pour ces informations ! Je serais disponible jeudi après-midi pour la visite. Est-ce que 15h vous conviendrait ?",
            "Merci pour votre réponse rapide. Ces informations sont rassurantes. Serait-il possible de visiter la propriété ce weekend ?",
            "Merci pour ces précisions. Le montant des charges me semble raisonnable. Je souhaiterais organiser une visite pour me faire une meilleure idée. Seriez-vous disponible samedi matin ?",
            "Merci beaucoup. Mercredi 10h me conviendrait parfaitement. Pourriez-vous me confirmer l'adresse exacte et le nom de la personne que je dois demander sur place ?",
            "Ces informations sont très utiles, merci ! Le quartier semble correspondre à mes attentes. Je souhaiterais maintenant visiter la propriété. Quelles sont vos disponibilités la semaine prochaine ?",
        ];
        
        // Tableau de réponses finales possibles (de l'agent à l'utilisateur)
        $agentFinalResponses = [
            "Parfait pour jeudi 15h ! Je vous confirme le rendez-vous. L'adresse est bien celle indiquée dans l'annonce. Je vous attendrai sur place. N'hésitez pas à me contacter si vous avez besoin d'indications supplémentaires.",
            "Bien sûr, je peux vous proposer une visite samedi. Je suis disponible à 10h ou 14h. Quelle heure vous conviendrait le mieux ? Je vous communiquerai tous les détails une fois l'horaire confirmé.",
            "Samedi matin serait parfait. Disons 11h ? Je vous attendrai directement devant l'immeuble. N'hésitez pas à m'appeler si vous avez du retard ou des difficultés à trouver.",
            "C'est noté pour mercredi 10h. L'adresse exacte est celle indiquée dans l'annonce. Je serai sur place pour vous accueillir. Mon nom est sur l'interphone. Au plaisir de vous rencontrer !",
            "Je suis disponible lundi et mardi après-midi de la semaine prochaine. Dites-moi quel jour et quelle heure vous conviendraient le mieux, et je vous confirmerai le rendez-vous.",
        ];
        
        // Pour chaque utilisateur, créer quelques conversations avec l'agent
        foreach ($users as $user) {
            // Nombre aléatoire de conversations pour cet utilisateur (entre 1 et 3)
            $numConversations = mt_rand(1, 3);
            
            // Sélectionner des propriétés aléatoires pour les conversations
            $randomProperties = $properties->random($numConversations);
            
            // Pour chaque propriété, créer une conversation
            foreach ($randomProperties as $property) {
                // Sélectionner un sujet aléatoire
                $subject = $subjects[array_rand($subjects)];
                
                // Sélectionner un message initial aléatoire
                $initialMessageIndex = array_rand($initialMessages);
                $initialMessage = $initialMessages[$initialMessageIndex];
                
                // Date de début de la conversation (entre 1 et 30 jours dans le passé)
                $startDate = Carbon::now()->subDays(mt_rand(1, 30));
                
                // Créer le message initial (de l'utilisateur à l'agent)
                $messageId = Message::insertGetId([
                    'sender_id' => $user->id,
                    'receiver_id' => $agent->id,
                    'property_id' => $property->id,
                    'subject' => $subject,
                    'message' => $initialMessage,
                    'read' => true, // L'agent a lu le message
                    'created_at' => $startDate,
                    'updated_at' => $startDate,
                ]);
                
                // 80% de chance d'avoir une réponse de l'agent
                if (mt_rand(1, 100) <= 80) {
                    // Date de la réponse (1 à 2 jours après le message initial)
                    $responseDate = (clone $startDate)->addDays(mt_rand(1, 2));
                    
                    // Sélectionner une réponse aléatoire de l'agent
                    $agentResponse = $agentResponses[array_rand($agentResponses)];
                    
                    // Créer la réponse de l'agent
                    $replyId = Message::insertGetId([
                        'sender_id' => $agent->id,
                        'receiver_id' => $user->id,
                        'property_id' => $property->id,
                        'subject' => 'Re: ' . $subject,
                        'message' => $agentResponse,
                        'parent_id' => $messageId, // Référence au message initial
                        'read' => mt_rand(0, 1), // 50% de chance que l'utilisateur ait lu la réponse
                        'created_at' => $responseDate,
                        'updated_at' => $responseDate,
                    ]);
                    
                    // 60% de chance d'avoir une réponse de suivi de l'utilisateur
                    if (mt_rand(1, 100) <= 60) {
                        // Date de la réponse de suivi (1 à 3 jours après la réponse de l'agent)
                        $followUpDate = (clone $responseDate)->addDays(mt_rand(1, 3));
                        
                        // Sélectionner une réponse de suivi aléatoire de l'utilisateur
                        $userFollowUp = $userFollowUps[array_rand($userFollowUps)];
                        
                        // Créer la réponse de suivi de l'utilisateur
                        $followUpId = Message::insertGetId([
                            'sender_id' => $user->id,
                            'receiver_id' => $agent->id,
                            'property_id' => $property->id,
                            'subject' => 'Re: ' . $subject,
                            'message' => $userFollowUp,
                            'parent_id' => $messageId, // Référence au message initial
                            'read' => true, // L'agent a lu le message
                            'created_at' => $followUpDate,
                            'updated_at' => $followUpDate,
                        ]);
                        
                        // 70% de chance d'avoir une réponse finale de l'agent
                        if (mt_rand(1, 100) <= 70) {
                            // Date de la réponse finale (1 à 2 jours après la réponse de suivi)
                            $finalDate = (clone $followUpDate)->addDays(mt_rand(1, 2));
                            
                            // Sélectionner une réponse finale aléatoire de l'agent
                            $agentFinalResponse = $agentFinalResponses[array_rand($agentFinalResponses)];
                            
                            // Créer la réponse finale de l'agent
                            Message::insert([
                                'sender_id' => $agent->id,
                                'receiver_id' => $user->id,
                                'property_id' => $property->id,
                                'subject' => 'Re: ' . $subject,
                                'message' => $agentFinalResponse,
                                'parent_id' => $messageId, // Référence au message initial
                                'read' => mt_rand(0, 1), // 50% de chance que l'utilisateur ait lu la réponse
                                'created_at' => $finalDate,
                                'updated_at' => $finalDate,
                            ]);
                        }
                    }
                }
            }
        }
        
        // Afficher un message de succès dans la console
        $this->command->info('Messages insérés avec succès!');
    }
}
