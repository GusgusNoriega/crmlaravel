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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('tipo', ['particular', 'empleado']);
            $table->string('email')->unique()->nullable();
            $table->unsignedBigInteger('ruc')->unique()->nullable();
            $table->unsignedBigInteger('imagen_destacada')->nullable();
            $table->foreign('imagen_destacada')->references('id')->on('images')->onDelete('set null');
            $table->string('telefono')->nullable();
            $table->string('cargo')->nullable();
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->unsignedBigInteger('area_id')->nullable(); // Asegúrate de que este tipo de dato coincida con el tipo de dato del ID en la tabla areas
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->unsignedBigInteger('sucursal_id')->nullable(); // Asegúrate de que este tipo de dato coincida con el tipo de dato del ID en la tabla areas
            $table->foreign('sucursal_id')->references('id')->on('sucursals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
