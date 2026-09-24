<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('status')->delete();

        DB::table('status')->insert(array (
            0 =>
            array (
                'id' => 1,
                'status_name' => 'Activo',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            1 =>
            array (
                'id' => 2,
                'status_name' => 'Inactivo',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            2 =>
            array (
                'id' => 3,
                'status_name' => 'Eliminado',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            3 =>
            array (
                'id' => 4,
                'status_name' => 'Disponible',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            4 =>
            array (
                'id' => 5,
                'status_name' => 'Descontinuado',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            5 =>
            array (
                'id' => 6,
                'status_name' => 'Agotado',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            6 =>
            array (
                'id' => 7,
                'status_name' => 'En revisión',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            7 =>
            array (
                'id' => 8,
                'status_name' => 'Pendiente',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            8 =>
            array (
                'id' => 9,
                'status_name' => 'Completado',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            9 =>
            array (
                'id' => 10,
                'status_name' => 'Cancelado',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            10 =>
            array (
                'id' => 11,
                'status_name' => 'Rechazado',
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
        ));


    }
}
