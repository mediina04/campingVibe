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
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('camping_id');
            $table->foreign('camping_id')->references('id')->on('campings')->onDelete('cascade');
            $table->boolean('disponible');
            $table->boolean('parking');
            $table->boolean('electricidad');
            $table->unsignedBigInteger('precio_noche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};
