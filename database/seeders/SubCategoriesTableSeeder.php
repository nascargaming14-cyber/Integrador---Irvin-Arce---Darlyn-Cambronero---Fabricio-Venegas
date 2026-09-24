<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sub_categories')->delete();
        
        \DB::table('sub_categories')->insert(array (
            0 => 
            array (
                'id' => 16,
                'subcategory_name' => 'Hule Procesado',
                'category_id' => 21,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:20:57',
            ),
            1 => 
            array (
                'id' => 40,
                'subcategory_name' => 'Esferas de 30 cm de diámetro',
                'category_id' => 16,
                'status_id' => 1,
                'created_at' => '2026-08-10 23:40:11',
                'updated_at' => '2026-08-10 23:54:15',
            ),
            2 => 
            array (
                'id' => 41,
                'subcategory_name' => 'Esferas de 40cm de diámetro',
                'category_id' => 16,
                'status_id' => 1,
                'created_at' => '2026-08-10 23:40:52',
                'updated_at' => '2026-08-10 23:54:32',
            ),
            3 => 
            array (
                'id' => 7,
                'subcategory_name' => 'Loseta',
                'category_id' => 17,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-10 23:57:24',
            ),
            4 => 
            array (
                'id' => 17,
                'subcategory_name' => 'Marcos De Fútbol',
                'category_id' => 21,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:22:31',
            ),
            5 => 
            array (
                'id' => 32,
                'subcategory_name' => 'Adoquín',
                'category_id' => 17,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-10 23:58:02',
            ),
            6 => 
            array (
                'id' => 33,
                'subcategory_name' => 'Loseta De Hule',
                'category_id' => 18,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-10 23:59:20',
            ),
            7 => 
            array (
                'id' => 36,
                'subcategory_name' => 'Cinta PVC',
                'category_id' => 18,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-10 23:59:58',
            ),
            8 => 
            array (
                'id' => 6,
                'subcategory_name' => 'Trébol Morado',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:01:36',
            ),
            9 => 
            array (
                'id' => 1,
                'subcategory_name' => 'Trébol Rojo',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:01:55',
            ),
            10 => 
            array (
                'id' => 2,
                'subcategory_name' => 'Trébol Naranja',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:02:12',
            ),
            11 => 
            array (
                'id' => 3,
                'subcategory_name' => 'Hoja De Begonia',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:02:40',
            ),
            12 => 
            array (
                'id' => 39,
                'subcategory_name' => 'Helecho Premium',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-08-10 23:02:12',
                'updated_at' => '2026-08-11 00:02:59',
            ),
            13 => 
            array (
                'id' => 4,
                'subcategory_name' => 'Hoja De Menta',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:03:17',
            ),
            14 => 
            array (
                'id' => 5,
                'subcategory_name' => 'Trébol Amarillo',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:03:37',
            ),
            15 => 
            array (
                'id' => 20,
                'subcategory_name' => 'Follaje Silvestre',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:04:08',
            ),
            16 => 
            array (
                'id' => 21,
                'subcategory_name' => 'Follaje Floral',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:04:26',
            ),
            17 => 
            array (
                'id' => 23,
                'subcategory_name' => 'Follaje Verde Sol',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:04:44',
            ),
            18 => 
            array (
                'id' => 30,
                'subcategory_name' => 'Follaje Primavera',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:05:07',
            ),
            19 => 
            array (
                'id' => 31,
                'subcategory_name' => 'Follaje Tropical',
                'category_id' => 19,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:05:28',
            ),
            20 => 
            array (
                'id' => 24,
                'subcategory_name' => 'X-PRO T-25',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 00:08:23',
            ),
            21 => 
            array (
                'id' => 37,
                'subcategory_name' => 'X-PRO MAX',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:00:50',
            ),
            22 => 
            array (
                'id' => 25,
                'subcategory_name' => 'X-PRO T-30',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:01:19',
            ),
            23 => 
            array (
                'id' => 29,
                'subcategory_name' => 'X-PRO PREMIUM',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:01:49',
            ),
            24 => 
            array (
                'id' => 15,
                'subcategory_name' => 'X-PRO DIAMOND',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:02:23',
            ),
            25 => 
            array (
                'id' => 14,
                'subcategory_name' => 'X-PRO EVERGREEN',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:02:49',
            ),
            26 => 
            array (
                'id' => 22,
            'subcategory_name' => 'Césped Innova (Blanco)',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:03:57',
            ),
            27 => 
            array (
                'id' => 26,
            'subcategory_name' => 'Césped Innova (Verde)',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:04:43',
            ),
            28 => 
            array (
                'id' => 10,
                'subcategory_name' => 'Césped Innova Propet',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:05:19',
            ),
            29 => 
            array (
                'id' => 8,
                'subcategory_name' => 'Golf Pro',
                'category_id' => 20,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:05:45',
            ),
            30 => 
            array (
                'id' => 9,
                'subcategory_name' => 'Rosado',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:07:15',
            ),
            31 => 
            array (
                'id' => 11,
                'subcategory_name' => 'Azul',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:07:38',
            ),
            32 => 
            array (
                'id' => 19,
                'subcategory_name' => 'Naranja',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:08:06',
            ),
            33 => 
            array (
                'id' => 35,
                'subcategory_name' => 'Rojo',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:08:29',
            ),
            34 => 
            array (
                'id' => 34,
                'subcategory_name' => 'Blanco',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:08:53',
            ),
            35 => 
            array (
                'id' => 38,
                'subcategory_name' => 'Amarillo',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-08-02 02:37:38',
                'updated_at' => '2026-08-11 19:09:18',
            ),
            36 => 
            array (
                'id' => 12,
                'subcategory_name' => 'Morado',
                'category_id' => 15,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:09:47',
            ),
            37 => 
            array (
                'id' => 28,
                'subcategory_name' => 'Malla Para Marcos',
                'category_id' => 21,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:22:56',
            ),
            38 => 
            array (
                'id' => 13,
                'subcategory_name' => 'Césped De Cancha',
                'category_id' => 21,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:17:49',
            ),
            39 => 
            array (
                'id' => 27,
                'subcategory_name' => 'Malla - Nylon',
                'category_id' => 22,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:29:25',
            ),
            40 => 
            array (
                'id' => 18,
                'subcategory_name' => 'Malla - Techo',
                'category_id' => 22,
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-08-11 19:29:50',
            ),
            41 => 
            array (
                'id' => 43,
                'subcategory_name' => 'Malla - Polietileno',
                'category_id' => 22,
                'status_id' => 1,
                'created_at' => '2026-08-11 19:27:29',
                'updated_at' => '2026-08-11 19:30:21',
            ),
            42 => 
            array (
                'id' => 44,
                'subcategory_name' => 'Piedra - Saco',
                'category_id' => 17,
                'status_id' => 1,
                'created_at' => '2026-08-11 19:42:54',
                'updated_at' => '2026-08-11 19:42:54',
            ),
            43 => 
            array (
                'id' => 45,
                'subcategory_name' => 'Shockpad',
                'category_id' => 18,
                'status_id' => 1,
                'created_at' => '2026-08-11 19:49:57',
                'updated_at' => '2026-08-11 19:49:57',
            ),
        ));
        
        
    }
}