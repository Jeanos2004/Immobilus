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
        // Pour l'instant, l'application est entièrement traduite en FR uniquement.
        // Quel que soit le paramètre reçu, on force le français.
        $locale = 'fr';
        
        // Stocker la langue dans la session
        Session::put('locale', $locale);
        
        // Rediriger vers la page précédente
        return redirect()->back();
    }
}
