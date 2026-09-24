<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('customers')->delete();
        
        \DB::table('customers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'customer_name' => 'Constructora San Carlos',
                'dni' => '208850839',
                'email' => 'compras@constructorasc.com',
                'telephone' => '86812409',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 21:54:07',
                'country' => 'CR',
                'id_type' => 'fisica',
            ),
            1 => 
            array (
                'id' => 2,
                'customer_name' => 'Complejo Deportivo Norte',
                'dni' => '156198514154415854',
                'email' => 'administracion@deportivonorte.com',
                'telephone' => '4922011362',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 21:54:47',
                'country' => 'MX',
                'id_type' => 'juridica',
            ),
            2 => 
            array (
                'id' => 3,
                'customer_name' => 'Municipalidad Local',
                'dni' => '79145565145',
                'email' => 'proveeduria@municipalidad.go.cr',
                'telephone' => '2964405253',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 21:55:14',
                'country' => 'AR',
                'id_type' => 'juridica',
            ),
            3 => 
            array (
                'id' => 4,
                'customer_name' => 'Jardines Tropicales',
                'dni' => '3109876544',
                'email' => 'ventas@jardinestropicales.com',
                'telephone' => '3147355614',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 21:55:52',
                'country' => 'CO',
                'id_type' => 'fisica',
            ),
            4 => 
            array (
                'id' => 6,
                'customer_name' => 'Universidad Nacional de Costa Rica',
                'dni' => '1234567890987',
                'email' => 'utn@gmail.com',
                'telephone' => '86812409',
                'status_id' => 2,
                'created_at' => '2026-07-27 16:20:20',
                'updated_at' => '2026-08-11 21:56:03',
                'country' => 'GT',
                'id_type' => 'fisica',
            ),
        ));
        
        
    }
}