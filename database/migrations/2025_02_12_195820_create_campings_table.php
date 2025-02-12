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
            $table->string('nombre');
            $table->string('poblacion');
            $table->string('telefono');
            $table->string('email');
            $table->string('web');
            $table->unsignedBigInteger('gps_latitud');
            $table->unsignedBigInteger('gps_longitud');
            $table->string('descripcion');
            $table->unsignedBigInteger('lavabos');
            $table->unsignedBigInteger('duchas');
            $table->unsignedBigInteger('fregaderos');
            $table->boolean('restaurante');
            $table->boolean('discoteca');
            $table->boolean('supermercado');
            $table->boolean('parque_infantil');
            $table->boolean('piscina');
            $table->boolean('medico');
            $table->boolean('perros_prohibidos');
            $table->boolean('minigolf');
            $table->boolean('barbacoas');
            $table->boolean('wifi');
            $table->boolean('petanca');
            $table->boolean('tenis');
            $table->boolean('padel');
            $table->boolean('fronton');
            $table->boolean('sala_fitness');
            $table->boolean('hipica');
            $table->boolean('alq_bicis');
            $table->boolean('alq_windsurf');
            $table->boolean('plancha');
            $table->boolean('campo_deportes');
            $table->boolean('deportes_aventura');
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
