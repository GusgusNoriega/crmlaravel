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
        Schema::create('procedencia_product', function (Blueprint $table) {
            $table->unsignedBigInteger('procedencia_id');
            $table->unsignedBigInteger('product_id');
        
            $table->foreign('procedencia_id')->references('id')->on('procedencias')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->primary(['procedencia_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedencia_product');
    }
};
