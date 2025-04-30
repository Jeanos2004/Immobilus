<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('property_reviews', function (Blueprint $table) {
            // Ajouter des colonnes pour les catégories de notation
            $table->tinyInteger('rating_location')->nullable()->comment('Note sur 5 pour l\'emplacement');
            $table->tinyInteger('rating_cleanliness')->nullable()->comment('Note sur 5 pour la propreté');
            $table->tinyInteger('rating_value')->nullable()->comment('Note sur 5 pour le rapport qualité-prix');
            $table->tinyInteger('rating_comfort')->nullable()->comment('Note sur 5 pour le confort');
            $table->tinyInteger('rating_amenities')->nullable()->comment('Note sur 5 pour les équipements');
            $table->tinyInteger('rating_accuracy')->nullable()->comment('Note sur 5 pour l\'exactitude de la description');
            // La colonne rating existante devient la note globale
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_reviews', function (Blueprint $table) {
            // Supprimer les colonnes ajoutées
            $table->dropColumn([
                'rating_location',
                'rating_cleanliness',
                'rating_value',
                'rating_comfort',
                'rating_amenities',
                'rating_accuracy'
            ]);
        });
    }
};
