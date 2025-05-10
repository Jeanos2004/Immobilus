<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sophie Martin',
                'position' => 'Propriétaire',
                'message' => 'Immobilus a rendu mon rêve de devenir propriétaire une réalité. Leur équipe professionnelle m\'a guidé à travers tout le processus d\'achat avec patience et expertise. Je recommande vivement leurs services !',
                'rating' => 5,
                'status' => 1,
            ],
            [
                'name' => 'Thomas Dubois',
                'position' => 'Investisseur immobilier',
                'message' => 'En tant qu\'investisseur immobilier, j\'ai travaillé avec de nombreuses agences, mais Immobilus se démarque par son professionnalisme et sa connaissance approfondie du marché. Ils m\'ont aidé à trouver des propriétés à fort potentiel et à maximiser mes rendements.',
                'rating' => 5,
                'status' => 1,
            ],
            [
                'name' => 'Emma Leroy',
                'position' => 'Locataire',
                'message' => 'J\'ai récemment loué un appartement par l\'intermédiaire d\'Immobilus et je suis impressionnée par leur service client. Ils ont été très réactifs à mes questions et ont facilité toutes les démarches administratives. Un grand merci à toute l\'équipe !',
                'rating' => 4,
                'status' => 1,
            ],
            [
                'name' => 'Lucas Bernard',
                'position' => 'Vendeur',
                'message' => 'Vendre ma maison était une décision difficile, mais l\'équipe d\'Immobilus a rendu ce processus beaucoup plus facile. Leur stratégie de marketing était exceptionnelle et ils ont réussi à vendre ma propriété au-dessus du prix du marché en seulement trois semaines !',
                'rating' => 5,
                'status' => 1,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
