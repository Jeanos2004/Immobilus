<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     * Cette migration crée la table favorites qui stocke les propriétés favorites des utilisateurs.
     * Elle établit une relation many-to-many entre les utilisateurs et les propriétés.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('property_id');
            $table->timestamps();
            
            // Contraintes de clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            
            // Assurer qu'un utilisateur ne peut pas ajouter la même propriété en favori plusieurs fois
            $table->unique(['user_id', 'property_id']);
        });
    }

    /**
     * Inverse les migrations.
     * Cette méthode supprime la table favorites si la migration est annulée.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
