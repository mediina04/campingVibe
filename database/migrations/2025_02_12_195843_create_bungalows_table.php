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
        Schema::create('bungalows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('camping_id');
            $table->foreign('camping_id')->references('id')->on('campings')->onDelete('cascade');
            $table->boolean('disponible');
            $table->unsignedBigInteger('num_personas');
            $table->boolean('sabanas');
            $table->boolean('cocina');
            $table->boolean('nevera');
            $table->boolean('TV');
            $table->boolean('acceso_minusv');
            $table->boolean('lavabo');
            $table->boolean('banera');
            $table->boolean('ducha');
            $table->boolean('calefaccion');
            $table->boolean('aire_acon');
            $table->boolean('menaje');
            $table->boolean('terraza');
            $table->unsignedBigInteger('precio_noche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bungalows');
    }
};
