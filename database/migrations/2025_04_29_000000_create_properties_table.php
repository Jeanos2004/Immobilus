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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('ptype_id');
            $table->unsignedBigInteger('agent_id');
            $table->string('property_name');
            $table->string('property_slug');
            $table->string('property_code');
            $table->string('property_status')->nullable();
            $table->string('lowest_price')->nullable();
            $table->string('max_price')->nullable();
            $table->string('property_thumbnail');
            $table->text('short_description');
            $table->text('long_description');
            $table->string('bedrooms')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('garage')->nullable();
            $table->string('garage_size')->nullable();
            $table->string('property_size');
            $table->string('property_video')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('featured')->nullable();
            $table->string('hot')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            
            // Clé étrangère
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
