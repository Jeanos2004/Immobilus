<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * Affiche toutes les propriétés ajoutées en favoris par les utilisateurs.
     *
     * Chaque ligne représente un favori (utilisateur + propriété).
     */
    public function index()
    {
        $favorites = Favorite::with(['user', 'property'])->latest()->get();

        return view('backend.favorites.all_favorites', compact('favorites'));
    }
}


