<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * movements_type_check solo aceptaba los tipos originales. Se reconstruye
     * conservando TODOS los valores que ya permitía y agregando 'entrada',
     * 'salida' y 'devolucion' (IV-02 e IV-03).
     */
    public function up(): void
    {
        $def = DB::selectOne(
            "select pg_get_constraintdef(oid) as def
               from pg_constraint
              where conname = 'movements_type_check'
                and conrelid = 'movements'::regclass"
        );

        // Si la restricción no existe en este ambiente, no hay nada que ampliar.
        if (! $def) {
            return;
        }

        preg_match_all("/'([^']+)'/", $def->def, $m);

        $tipos = array_values(array_unique(array_merge($m[1] ?? [], ['entrada', 'salida', 'devolucion'])));

        $this->recrear($tipos);
    }

    /**
     * Quita 'devolucion' de los tipos permitidos. Falla si ya hay movimientos
     * de ese tipo (a propósito: no se pierde historial).
     */
    public function down(): void
    {
        $def = DB::selectOne(
            "select pg_get_constraintdef(oid) as def
               from pg_constraint
              where conname = 'movements_type_check'
                and conrelid = 'movements'::regclass"
        );

        if (! $def) {
            return;
        }

        preg_match_all("/'([^']+)'/", $def->def, $m);

        $tipos = array_values(array_diff(array_unique($m[1] ?? []), ['devolucion']));

        $this->recrear($tipos);
    }

    private function recrear(array $tipos): void
    {
        $lista = implode(', ', array_map(
            fn ($t) => "'" . str_replace("'", "''", $t) . "'",
            $tipos
        ));

        DB::statement('ALTER TABLE movements DROP CONSTRAINT IF EXISTS movements_type_check');
        DB::statement("ALTER TABLE movements ADD CONSTRAINT movements_type_check CHECK (type IN ({$lista}))");
    }
};
