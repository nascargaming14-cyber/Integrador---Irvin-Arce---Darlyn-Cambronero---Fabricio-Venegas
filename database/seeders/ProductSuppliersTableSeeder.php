<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_suppliers')->delete();
        
        \DB::table('product_suppliers')->insert(array (
            0 => 
            array (
                'id' => 18,
                'product_id' => 15,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-10 23:45:08',
                'updated_at' => '2026-08-10 23:51:18',
            ),
            1 => 
            array (
                'id' => 17,
                'product_id' => 16,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-07-29 17:44:53',
                'updated_at' => '2026-08-10 23:51:48',
            ),
            2 => 
            array (
                'id' => 19,
                'product_id' => 16,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-08-10 23:51:48',
                'updated_at' => '2026-08-10 23:51:48',
            ),
            3 => 
            array (
                'id' => 20,
                'product_id' => 17,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-08-11 00:10:10',
                'updated_at' => '2026-08-11 00:10:10',
            ),
            4 => 
            array (
                'id' => 2,
                'product_id' => 2,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:46:02',
            ),
            5 => 
            array (
                'id' => 3,
                'product_id' => 3,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:46:09',
            ),
            6 => 
            array (
                'id' => 4,
                'product_id' => 4,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:46:16',
            ),
            7 => 
            array (
                'id' => 15,
                'product_id' => 4,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-07-19 19:55:49',
                'updated_at' => '2026-08-11 19:46:16',
            ),
            8 => 
            array (
                'id' => 5,
                'product_id' => 5,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:47:50',
            ),
            9 => 
            array (
                'id' => 6,
                'product_id' => 6,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:51:09',
            ),
            10 => 
            array (
                'id' => 8,
                'product_id' => 7,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:58:41',
            ),
            11 => 
            array (
                'id' => 9,
                'product_id' => 8,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 19:59:30',
            ),
            12 => 
            array (
                'id' => 10,
                'product_id' => 9,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 20:00:38',
            ),
            13 => 
            array (
                'id' => 11,
                'product_id' => 10,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 20:01:56',
            ),
            14 => 
            array (
                'id' => 12,
                'product_id' => 11,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 20:03:22',
            ),
            15 => 
            array (
                'id' => 22,
                'product_id' => 13,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-08-11 19:20:12',
                'updated_at' => '2026-08-11 20:04:39',
            ),
            16 => 
            array (
                'id' => 21,
                'product_id' => 14,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 19:18:54',
                'updated_at' => '2026-08-11 20:06:10',
            ),
            17 => 
            array (
                'id' => 23,
                'product_id' => 18,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:07:51',
                'updated_at' => '2026-08-11 20:07:51',
            ),
            18 => 
            array (
                'id' => 24,
                'product_id' => 19,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:08:49',
                'updated_at' => '2026-08-11 20:08:49',
            ),
            19 => 
            array (
                'id' => 25,
                'product_id' => 20,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:09:39',
                'updated_at' => '2026-08-11 20:09:39',
            ),
            20 => 
            array (
                'id' => 26,
                'product_id' => 21,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:11:41',
                'updated_at' => '2026-08-11 20:11:41',
            ),
            21 => 
            array (
                'id' => 27,
                'product_id' => 22,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:12:37',
                'updated_at' => '2026-08-11 20:12:37',
            ),
            22 => 
            array (
                'id' => 28,
                'product_id' => 23,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:16:57',
                'updated_at' => '2026-08-11 20:16:57',
            ),
            23 => 
            array (
                'id' => 29,
                'product_id' => 24,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:18:19',
                'updated_at' => '2026-08-11 20:18:19',
            ),
            24 => 
            array (
                'id' => 30,
                'product_id' => 25,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:19:23',
                'updated_at' => '2026-08-11 20:19:23',
            ),
            25 => 
            array (
                'id' => 31,
                'product_id' => 26,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:20:28',
                'updated_at' => '2026-08-11 20:22:13',
            ),
            26 => 
            array (
                'id' => 33,
                'product_id' => 28,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:24:16',
                'updated_at' => '2026-08-11 20:24:16',
            ),
            27 => 
            array (
                'id' => 34,
                'product_id' => 29,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:25:14',
                'updated_at' => '2026-08-11 20:25:14',
            ),
            28 => 
            array (
                'id' => 35,
                'product_id' => 30,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:27:44',
                'updated_at' => '2026-08-11 20:27:44',
            ),
            29 => 
            array (
                'id' => 36,
                'product_id' => 31,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:28:45',
                'updated_at' => '2026-08-11 20:28:45',
            ),
            30 => 
            array (
                'id' => 37,
                'product_id' => 32,
                'supplier_id' => 3,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:30:48',
                'updated_at' => '2026-08-11 20:30:48',
            ),
            31 => 
            array (
                'id' => 38,
                'product_id' => 33,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:31:35',
                'updated_at' => '2026-08-11 20:31:35',
            ),
            32 => 
            array (
                'id' => 39,
                'product_id' => 34,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:32:49',
                'updated_at' => '2026-08-11 20:32:49',
            ),
            33 => 
            array (
                'id' => 40,
                'product_id' => 35,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:34:13',
                'updated_at' => '2026-08-11 20:34:13',
            ),
            34 => 
            array (
                'id' => 41,
                'product_id' => 36,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:35:42',
                'updated_at' => '2026-08-11 20:35:42',
            ),
            35 => 
            array (
                'id' => 42,
                'product_id' => 37,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:37:35',
                'updated_at' => '2026-08-11 20:37:35',
            ),
            36 => 
            array (
                'id' => 43,
                'product_id' => 38,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:38:17',
                'updated_at' => '2026-08-11 20:38:17',
            ),
            37 => 
            array (
                'id' => 44,
                'product_id' => 39,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:40:57',
                'updated_at' => '2026-08-11 20:40:57',
            ),
            38 => 
            array (
                'id' => 45,
                'product_id' => 40,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:46:05',
                'updated_at' => '2026-08-11 20:46:05',
            ),
            39 => 
            array (
                'id' => 46,
                'product_id' => 41,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:48:17',
                'updated_at' => '2026-08-11 20:48:17',
            ),
            40 => 
            array (
                'id' => 47,
                'product_id' => 42,
                'supplier_id' => 2,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:49:08',
                'updated_at' => '2026-08-11 20:49:08',
            ),
            41 => 
            array (
                'id' => 48,
                'product_id' => 43,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:52:39',
                'updated_at' => '2026-08-11 20:52:39',
            ),
            42 => 
            array (
                'id' => 49,
                'product_id' => 44,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:54:20',
                'updated_at' => '2026-08-11 20:56:33',
            ),
            43 => 
            array (
                'id' => 51,
                'product_id' => 46,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:58:52',
                'updated_at' => '2026-08-11 20:58:52',
            ),
            44 => 
            array (
                'id' => 52,
                'product_id' => 47,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 21:00:15',
                'updated_at' => '2026-08-11 21:00:15',
            ),
            45 => 
            array (
                'id' => 50,
                'product_id' => 45,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 20:55:48',
                'updated_at' => '2026-08-11 21:00:41',
            ),
            46 => 
            array (
                'id' => 53,
                'product_id' => 48,
                'supplier_id' => 6,
                'status_id' => 4,
                'created_at' => '2026-08-11 21:01:46',
                'updated_at' => '2026-08-11 21:01:46',
            ),
            47 => 
            array (
                'id' => 32,
                'product_id' => 27,
                'supplier_id' => 6,
                'status_id' => 2,
                'created_at' => '2026-08-11 20:21:43',
                'updated_at' => '2026-08-11 21:15:38',
            ),
            48 => 
            array (
                'id' => 54,
                'product_id' => 49,
                'supplier_id' => 6,
                'status_id' => 5,
                'created_at' => '2026-08-19 14:21:33',
                'updated_at' => '2026-08-19 14:31:48',
            ),
            49 => 
            array (
                'id' => 1,
                'product_id' => 1,
                'supplier_id' => 1,
                'status_id' => 4,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-09-25 20:56:17',
            ),
        ));
        
        
    }
}