<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('suppliers')->delete();

        DB::table('suppliers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Guatemala',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Brasil',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Japón',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            3 =>
            array (
                'id' => 6,
                'name' => 'Costa Rica',
                'status_id' => 1,
                'created_at' => '2026-07-19 19:56:01',
                'updated_at' => '2026-07-27 16:24:00',
            ),
            4 =>
            array (
                'id' => 7,
                'name' => 'panama',
                'status_id' => 2,
                'created_at' => '2026-08-19 15:58:44',
                'updated_at' => '2026-08-24 20:32:31',
            ),
        ));


    }
}
