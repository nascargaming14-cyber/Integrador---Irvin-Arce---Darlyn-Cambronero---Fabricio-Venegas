<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crews', function (Blueprint $table) {
            // "code" sigue siendo único (para la base de datos).
            // "label" es la letra que se ve en la pizarra y SÍ puede repetirse (ej. dos "A").
            $table->string('label', 10)->nullable()->after('code');
            $table->unsignedInteger('sort_order')->default(0)->after('label');
        });

        // Por defecto, que el label sea igual al code para las cuadrillas ya creadas.
        DB::table('crews')->update(['label' => DB::raw('code')]);
    }

    public function down(): void
    {
        Schema::table('crews', function (Blueprint $table) {
            $table->dropColumn(['label', 'sort_order']);
        });
    }
};
