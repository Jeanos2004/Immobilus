<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     * Cette migration crée la table messages qui stocke les communications entre utilisateurs et agents.
     * Chaque message a un expéditeur, un destinataire, un sujet, un contenu et peut être lié à une propriété.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();
            
            // Contraintes de clés étrangères
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
        });
    }

    /**
     * Inverse les migrations.
     * Cette méthode supprime la table messages si la migration est annulée.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
