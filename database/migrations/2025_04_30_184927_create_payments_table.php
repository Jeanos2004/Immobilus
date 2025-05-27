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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->foreignId('payment_plan_id')->nullable()->constrained('payment_plans')->onDelete('set null');
            $table->string('payment_type'); // reservation, acompte, location, achat
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('EUR');
            $table->string('payment_method'); // carte, virement, paypal, etc.
            $table->string('transaction_id')->nullable(); // ID de transaction du processeur de paiement
            $table->string('status'); // pending, completed, failed, refunded
            $table->text('notes')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
