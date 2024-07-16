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
        Schema::create('monedas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la moneda
            $table->string('code', 10)->nullable(); // Código de la moneda, por ejemplo, USD, EUR
            $table->string('symbol', 10)->nullable(); // Símbolo de la moneda, por ejemplo, $, €
            $table->decimal('tipo_cambio', 8, 2)->nullable(); // Tipo de cambio con máximo 2 decimales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monedas');
    }
};
