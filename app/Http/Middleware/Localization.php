<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si une langue est stockée en session
        if (Session::has('locale')) {
            // Appliquer la langue stockée en session
            App::setLocale(Session::get('locale'));
        } else {
            // Par défaut, utiliser le français
            App::setLocale('fr');
        }
        
        return $next($request);
    }
}
