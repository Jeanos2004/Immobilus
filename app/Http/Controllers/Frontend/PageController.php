<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Property;

class PageController extends Controller
{
    /**
     * Affiche la page À propos
     */
    public function about()
    {
        // Récupérer quelques témoignages pour la page À propos
        $testimonials = Testimonial::where('status', 1)->inRandomOrder()->limit(3)->get();
        
        // Récupérer les agents pour la page À propos
        $agents = User::where('role', 'agent')->where('status', 'active')->inRandomOrder()->limit(4)->get();
        
        // Statistiques pour la page À propos
        $stats = [
            'properties' => Property::count(),
            'agents' => User::where('role', 'agent')->count(),
            'clients' => User::where('role', 'user')->count(),
            'cities' => Property::distinct('city')->count('city')
        ];
        
        return view('frontend.pages.about', compact('testimonials', 'agents', 'stats'));
    }
    
    /**
     * Affiche la page FAQ
     */
    public function faq()
    {
        return view('frontend.pages.faq');
    }
    
    /**
     * Affiche la page Politique de confidentialité
     */
    public function privacy()
    {
        return view('frontend.pages.privacy');
    }
    
    /**
     * Affiche la page Conditions d'utilisation
     */
    public function terms()
    {
        return view('frontend.pages.terms');
    }
    
    /**
     * Affiche la calculatrice de prêt immobilier
     */
    public function mortgageCalculator()
    {
        return view('frontend.pages.mortgage_calculator');
    }
}
