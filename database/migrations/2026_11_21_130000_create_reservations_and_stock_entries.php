<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Stock comprometido por reservas de proyecto.
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('reserved_stock', 12, 2)->default(0);
        });

        // La base misma impide reservar de más o dejar reservas negativas.
        DB::statement('ALTER TABLE products ADD CONSTRAINT products_reserved_valido CHECK (reserved_stock >= 0 AND reserved_stock <= stock)');

        // Entradas de inventario (compra o proveedor).
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->string('reference', 100)->nullable();
            $table->decimal('quantity', 12, 2);
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Reservas de material por proyecto.
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('project_name', 150);
            $table->decimal('quantity', 12, 2);
            $table->string('status', 20)->default('activa'); // activa | despachada | cancelada
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('stock_entries');

        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_reserved_valido');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('reserved_stock');
        });
    }
};
