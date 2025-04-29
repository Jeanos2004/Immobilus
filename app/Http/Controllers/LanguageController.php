<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change the application language
     * 
     * @param Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        // Vérifier si la langue est prise en charge
        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'fr'; // Langue par défaut (français)
        }
        
        // Stocker la langue dans la session
        Session::put('locale', $locale);
        
        // Rediriger vers la page précédente
        return redirect()->back();
    }
}
