<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();   // Ej: "C", "J", "A"... (letra que se ve en la pizarra)
            $table->string('name')->nullable();     // Ej: "Cuadrilla 1 - Camión blanco"
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
