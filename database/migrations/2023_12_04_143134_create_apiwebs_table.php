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
        Schema::create('apiwebs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('web')->nullable();
            $table->string('clave_key')->nullable();
            $table->string('clave_secret')->nullable();
            $table->string('tipo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apiwebs');
    }
};
