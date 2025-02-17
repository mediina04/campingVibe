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
        Schema::create('imagen_campings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('camping_id');
            $table->foreign('camping_id')->references('id')->on('campings')->onDelete('cascade');
            $table->string('nombre_img');
            $table->boolean('img_principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen_campings');
    }
};
