<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE products ADD CONSTRAINT products_stock_no_negativo CHECK (stock >= 0)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE products DROP CONSTRAINT products_stock_no_negativo');
    }
};
