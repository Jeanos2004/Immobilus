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
        Schema::table('messages', function (Blueprint $table) {
            // Ajouter la colonne parent_id pour gérer les réponses aux messages
            // Cette colonne fait référence à l'ID du message parent (message initial d'une conversation)
            $table->unsignedBigInteger('parent_id')->nullable()->after('message');
            
            // Ajouter la contrainte de clé étrangère pour parent_id
            $table->foreign('parent_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Supprimer d'abord la contrainte de clé étrangère
            $table->dropForeign(['parent_id']);
            
            // Puis supprimer la colonne
            $table->dropColumn('parent_id');
        });
    }
};
