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
        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('property_reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('reason', ['spam', 'offensive', 'inappropriate', 'fake', 'other'])->comment('Raison du signalement');
            $table->text('details')->nullable()->comment('Détails supplémentaires sur le signalement');
            $table->enum('status', ['pending', 'reviewed', 'dismissed'])->default('pending');
            $table->text('admin_notes')->nullable()->comment('Notes de l\'administrateur sur le signalement');
            $table->timestamps();
            
            // Un utilisateur ne peut signaler qu'une seule fois un même avis
            $table->unique(['review_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reports');
    }
};
