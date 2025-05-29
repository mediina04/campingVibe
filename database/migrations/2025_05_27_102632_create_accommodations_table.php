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
        Schema::create('accommodations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('camping_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['bungalow', 'parcela']);
        $table->string('name')->nullable();
        $table->decimal('price_per_night', 8, 2);
        $table->integer('capacity');
        $table->text('description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
