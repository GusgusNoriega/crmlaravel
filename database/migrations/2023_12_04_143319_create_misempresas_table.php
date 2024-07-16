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
        Schema::create('misempresas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('ruc')->unique();
            $table->string('alias')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedBigInteger('imagen_logo')->nullable(); // Agrega esta línea
            $table->unsignedBigInteger('imagen_sello')->nullable(); // Agrega esta línea
            $table->foreign('imagen_logo')->references('id')->on('images')->onDelete('set null');
            $table->foreign('imagen_sello')->references('id')->on('images')->onDelete('set null');
            $table->string('cuenta_soles')->nullable();
            $table->string('cuenta_dolares')->nullable();
            $table->string('cuenta_nacion')->nullable();
            $table->timestamps();
        });

     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misempresas');
    }
};
