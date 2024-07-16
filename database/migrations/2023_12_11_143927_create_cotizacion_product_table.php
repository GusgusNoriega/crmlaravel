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
        Schema::create('cotizacion_product', function (Blueprint $table) {
            
            $table->unsignedBigInteger('cotizacion_id');
            $table->foreign('cotizacion_id')->references('id')->on('cotizacions')->onDelete('cascade');
        
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('moneda_actual', 8, 2)->nullable();
            $table->string('moneda_final', 8, 2)->nullable();

            $table->decimal('tipo_cambio_actual', 8, 2)->nullable();
            $table->decimal('tipo_cambio_final', 8, 2)->nullable();

            $table->decimal('precio_actual', 8, 2)->nullable();
            $table->decimal('precio_final', 8, 2)->nullable();

            $table->decimal('precio_descuento', 8, 2)->nullable();

            $table->integer('cantidad')->nullable();

            $table->decimal('total', 15, 2)->nullable();

            $table->primary(['cotizacion_id', 'product_id']); // Clave primaria compuesta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_product');
    }
};
