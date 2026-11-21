<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Devoluciones de material sobrante de una reserva ya despachada.
        // La salida original no se borra: la devolución es un registro aparte.
        Schema::create('stock_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity', 12, 2);
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE stock_returns ADD CONSTRAINT stock_returns_cantidad_positiva CHECK (quantity > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_returns');
    }
};
