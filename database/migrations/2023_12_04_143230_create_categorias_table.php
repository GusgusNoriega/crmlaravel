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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('imagen_destacada')->nullable();
            $table->foreign('imagen_destacada')->references('id')->on('images')->onDelete('set null');
            $table->unsignedBigInteger('categoria_padre_id')->nullable();
            $table->foreign('categoria_padre_id')->references('id')->on('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
