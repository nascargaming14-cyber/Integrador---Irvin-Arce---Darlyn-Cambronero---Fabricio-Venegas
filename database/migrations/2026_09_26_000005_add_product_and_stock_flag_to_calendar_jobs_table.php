<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calendar_jobs', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('crew_id')
                ->constrained('products')->nullOnDelete();

            // Evita descontar el stock dos veces, y permite saber si hay
            // que devolverlo cuando se desconfirma o se elimina el trabajo.
            $table->boolean('stock_deducted')->default(false)->after('confirmed');
        });
    }

    public function down(): void
    {
        Schema::table('calendar_jobs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
            $table->dropColumn('stock_deducted');
        });
    }
};
