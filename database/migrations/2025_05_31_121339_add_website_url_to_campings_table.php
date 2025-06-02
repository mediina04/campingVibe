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
        Schema::table('campings', function (Blueprint $table) {
            // Agrega una columna para almacenar la URL de la web del camping
            $table->string('website_url')->nullable()->after('id');

            // Agrega una columna para almacenar múltiples imágenes como JSON
            $table->json('images')->nullable()->after('website_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campings', function (Blueprint $table) {
            $table->dropColumn('website_url');
            $table->dropColumn('images');
        });
    }
};
