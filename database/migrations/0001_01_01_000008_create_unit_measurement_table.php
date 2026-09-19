<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_measurement', function (Blueprint $table) {
            $table->id();
            $table->string('unit_name', 50)->unique();
            $table->foreignId('status_id')->constrained('status')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_measurement');
    }
};