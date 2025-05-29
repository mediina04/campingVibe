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
    Schema::create('campings', function (Blueprint $table) {
        $table->id();
        $table->string('name');            // Nombre del camping
        $table->string('location');        // Ciudad o dirección
        $table->text('description')->nullable(); // Descripción opcional
        $table->decimal('rating_avg', 3, 2)->default(0); // Media de valoraciones (ej: 4.25)
        $table->timestamps();              // created_at y updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campings');
    }
};
