<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('sub_category_unit_measurement', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sub_category_id')->constrained('sub_categories')->cascadeOnDelete();
        $table->foreignId('unit_id')->constrained('unit_measurement')->cascadeOnDelete();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('sub_category_unit_measurement');
}
};
