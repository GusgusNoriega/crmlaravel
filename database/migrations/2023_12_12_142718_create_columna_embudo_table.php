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
        Schema::create('columna_embudo', function (Blueprint $table) {
            $table->foreignId('columna_id')->constrained()->onDelete('cascade');
            $table->foreignId('embudo_id')->constrained()->onDelete('cascade');
            $table->decimal('posicion', 5, 2);
            $table->timestamps();
            $table->primary(['columna_id', 'embudo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columna_embudo');
    }
};
