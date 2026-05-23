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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('registration_number')->unique();
            $table->enum('type', ['car', 'cab', 'van', 'minibus', 'bus']);
            $table->decimal('price_per_km', 8, 2); // Changed from price_per_day
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('passengers')->nullable(); // New field for passenger capacity
            $table->json('features')->nullable(); // New field for features as JSON
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};