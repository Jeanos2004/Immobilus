<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     * Cette migration crée la table property_images qui stocke toutes les images supplémentaires
     * pour chaque propriété, permettant d'avoir une galerie complète.
     */
    public function up(): void
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('photo_name');
            $table->timestamps();
            
            // Contrainte de clé étrangère
            // Si une propriété est supprimée, toutes ses images seront également supprimées
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Inverse les migrations.
     * Cette méthode supprime la table property_images si la migration est annulée.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};
