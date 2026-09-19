<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('header_order_id')->constrained('header_orders')->onDelete('restrict');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->decimal('quantity', 10, 2);
            $table->string('barcode', 100)->nullable();
            $table->string('product_name', 150)->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva', 10, 2)->default(0);
            $table->foreignId('status_id')->constrained('status')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};