<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_name' => 'Administrador',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            1 => 
            array (
                'id' => 2,
                'role_name' => 'Ventas',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            2 => 
            array (
                'id' => 3,
                'role_name' => 'Supervisor de Ventas',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            3 => 
            array (
                'id' => 4,
                'role_name' => 'Bodega',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            4 => 
            array (
                'id' => 5,
                'role_name' => 'Compras',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            5 => 
            array (
                'id' => 6,
                'role_name' => 'Gerencia',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
        ));
        
        
    }
}