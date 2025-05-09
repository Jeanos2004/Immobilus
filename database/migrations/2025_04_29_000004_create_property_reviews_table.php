<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     * Cette migration crée la table property_reviews qui stocke les avis des utilisateurs sur les propriétés.
     * Chaque avis contient une note (rating), un commentaire et est lié à un utilisateur et une propriété.
     */
    public function up(): void
    {
        Schema::create('property_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating')->comment('Note sur 5');
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            // Contraintes de clés étrangères
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Un utilisateur ne peut laisser qu'un seul avis par propriété
            $table->unique(['property_id', 'user_id']);
        });
    }

    /**
     * Inverse les migrations.
     * Cette méthode supprime la table property_reviews si la migration est annulée.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_reviews');
    }
};
