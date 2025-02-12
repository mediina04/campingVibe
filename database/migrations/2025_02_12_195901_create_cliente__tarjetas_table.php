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
        Schema::create('cliente__tarjetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_descuento_id');
            $table->foreign('tipo_descuento_id')->references('id')->on('tipo_descuentos')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->date('fecha_adquisicion');
            $table->date('fecha_caducidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente__tarjetas');
    }
};
