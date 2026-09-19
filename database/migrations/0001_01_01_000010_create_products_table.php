<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 100)->unique();
            $table->string('product_name', 150);
            $table->decimal('stock', 10, 2)->default(0);
            $table->decimal('minimum_stock', 10, 2)->default(0);
            $table->decimal('price_sale', 10, 2);
            $table->decimal('price_buy', 10, 2);
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('restrict');
            $table->foreignId('unit_id')->constrained('unit_measurement')->onDelete('restrict');
            $table->foreignId('status_id')->constrained('status')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};