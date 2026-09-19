<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->foreignId('order_detail_id')
                ->nullable()
                ->after('product_id')
                ->constrained('order_details')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_detail_id');
        });
    }
};