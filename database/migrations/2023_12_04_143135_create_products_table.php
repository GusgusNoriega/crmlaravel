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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('id_referencia')->nullable();
            $table->string('title');
            $table->string('tipo')->nullable();
            $table->integer('sku_ref')->nullable();
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->text('cont_envio')->nullable();
            $table->text('datos_tecnicos')->nullable();
            $table->string('modelo')->nullable();
            $table->unsignedBigInteger('moneda')->nullable(); 
            $table->foreign('moneda')->references('id')->on('monedas')->onDelete('set null');
            $table->decimal('precio', 10, 2);
            $table->unsignedBigInteger('imagen_destacada')->nullable();
            $table->foreign('imagen_destacada')->references('id')->on('images')->onDelete('set null');
            $table->unsignedBigInteger('apiweb_id')->nullable();
            $table->foreign('apiweb_id')->references('id')->on('apiwebs')->onDelete('set null');
            $table->unsignedBigInteger('galeria_id')->nullable();
            $table->foreign('galeria_id')->references('id')->on('galerias')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
