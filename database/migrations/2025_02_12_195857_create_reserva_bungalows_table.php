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
        Schema::create('reserva_bungalows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parcela_id');
            $table->foreign('parcela_id')->references('id')->on('parcelas')->onDelete('cascade');
            $table->unsignedBigInteger('camping_id');
            $table->foreign('camping_id')->references('id')->on('campings')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->unsignedBigInteger('importe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_bungalows');
    }
};
