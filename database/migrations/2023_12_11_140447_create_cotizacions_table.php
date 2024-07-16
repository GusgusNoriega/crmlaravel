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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            
            $table->integer('nro_cotizacion')->nullable();
            $table->date('fecha_cotizacion')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('entrega')->nullable();
            $table->string('lugar_entrega')->nullable();
            $table->string('garantia')->nullable();
            $table->string('forma_de_pago')->nullable();
            $table->decimal('tipo_de_cambio', 8, 2)->nullable();
            $table->string('adicionales')->nullable();
            $table->decimal('total', 15, 2)->nullable();

            $table->unsignedBigInteger('misempresa_id')->nullable();
            $table->foreign('misempresa_id')
                  ->references('id')->on('misempresas')
                  ->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')
                  ->references('id')->on('clientes')
                  ->onDelete('set null'); 
                  
            $table->unsignedBigInteger('moneda_id')->nullable();
            $table->foreign('moneda_id')
                  ->references('id')->on('monedas')
                  ->onDelete('set null');   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacions');
    }
};
