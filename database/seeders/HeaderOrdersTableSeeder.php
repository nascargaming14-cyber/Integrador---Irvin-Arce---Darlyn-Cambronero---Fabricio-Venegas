<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HeaderOrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('header_orders')->delete();
        
        \DB::table('header_orders')->insert(array (
            0 => 
            array (
                'id' => 16,
                'customer_id' => 2,
                'order_status' => 'completado',
                'order_date' => '2026-07-19 01:13:41',
                'order_amount' => '1710.00',
                'discount' => '0.00',
                'total' => '1932.30',
                'status_id' => 1,
                'created_at' => '2026-07-19 01:13:41',
                'updated_at' => '2026-08-11 21:20:16',
            ),
            1 => 
            array (
                'id' => 17,
                'customer_id' => 2,
                'order_status' => 'completado',
                'order_date' => '2026-07-19 01:50:01',
                'order_amount' => '15048.00',
                'discount' => '0.00',
                'total' => '17004.24',
                'status_id' => 1,
                'created_at' => '2026-07-19 01:50:01',
                'updated_at' => '2026-08-11 21:21:40',
            ),
            2 => 
            array (
                'id' => 18,
                'customer_id' => 2,
                'order_status' => 'en proceso',
                'order_date' => '2026-07-19 01:55:50',
                'order_amount' => '450000.00',
                'discount' => '0.00',
                'total' => '508500.00',
                'status_id' => 1,
                'created_at' => '2026-07-19 01:55:50',
                'updated_at' => '2026-08-11 21:22:21',
            ),
            3 => 
            array (
                'id' => 19,
                'customer_id' => 2,
                'order_status' => 'en proceso',
                'order_date' => '2026-07-19 01:58:04',
                'order_amount' => '70500.00',
                'discount' => '0.00',
                'total' => '79665.00',
                'status_id' => 8,
                'created_at' => '2026-07-19 01:58:04',
                'updated_at' => '2026-08-11 21:23:00',
            ),
            4 => 
            array (
                'id' => 20,
                'customer_id' => 2,
                'order_status' => 'completado',
                'order_date' => '2026-07-20 22:11:14',
                'order_amount' => '2736.00',
                'discount' => '0.00',
                'total' => '3091.68',
                'status_id' => 1,
                'created_at' => '2026-07-20 22:11:14',
                'updated_at' => '2026-08-11 21:23:41',
            ),
            5 => 
            array (
                'id' => 21,
                'customer_id' => 2,
                'order_status' => 'completado',
                'order_date' => '2026-07-25 19:55:58',
                'order_amount' => '2394.00',
                'discount' => '900.00',
                'total' => '1805.22',
                'status_id' => 1,
                'created_at' => '2026-07-25 19:55:58',
                'updated_at' => '2026-08-11 21:24:15',
            ),
            6 => 
            array (
                'id' => 24,
                'customer_id' => 4,
                'order_status' => 'en proceso',
                'order_date' => '2026-07-27 16:08:36',
                'order_amount' => '148000.00',
                'discount' => '0.00',
                'total' => '167240.00',
                'status_id' => 1,
                'created_at' => '2026-07-27 16:08:36',
                'updated_at' => '2026-08-11 21:25:26',
            ),
            7 => 
            array (
                'id' => 25,
                'customer_id' => 2,
                'order_status' => 'en proceso',
                'order_date' => '2026-08-10 19:30:51',
                'order_amount' => '386400.00',
                'discount' => '0.00',
                'total' => '436632.00',
                'status_id' => 7,
                'created_at' => '2026-08-10 19:30:51',
                'updated_at' => '2026-08-11 21:26:18',
            ),
            8 => 
            array (
                'id' => 26,
                'customer_id' => 6,
                'order_status' => 'en proceso',
                'order_date' => '2026-08-10 19:37:19',
                'order_amount' => '195000.00',
                'discount' => '0.00',
                'total' => '220350.00',
                'status_id' => 1,
                'created_at' => '2026-08-10 19:37:19',
                'updated_at' => '2026-08-11 21:26:53',
            ),
            9 => 
            array (
                'id' => 22,
                'customer_id' => 1,
                'order_status' => 'en proceso',
                'order_date' => '2026-07-26 03:58:57',
                'order_amount' => '1024500.00',
                'discount' => '0.00',
                'total' => '1157685.00',
                'status_id' => 7,
                'created_at' => '2026-07-26 03:58:57',
                'updated_at' => '2026-07-26 03:58:57',
            ),
            10 => 
            array (
                'id' => 23,
                'customer_id' => 4,
                'order_status' => 'completado',
                'order_date' => '2026-07-27 16:08:32',
                'order_amount' => '92500.00',
                'discount' => '0.00',
                'total' => '104525.00',
                'status_id' => 1,
                'created_at' => '2026-07-27 16:08:32',
                'updated_at' => '2026-08-11 21:05:45',
            ),
            11 => 
            array (
                'id' => 1,
                'customer_id' => 1,
                'order_status' => 'pendiente',
                'order_date' => '2026-06-05 23:32:54',
                'order_amount' => '207500.00',
                'discount' => '10000.00',
                'total' => '224475.00',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 21:06:19',
            ),
            12 => 
            array (
                'id' => 2,
                'customer_id' => 2,
                'order_status' => 'pendiente',
                'order_date' => '2026-06-08 23:32:54',
                'order_amount' => '231000.00',
                'discount' => '5000.00',
                'total' => '256030.00',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 21:07:03',
            ),
            13 => 
            array (
                'id' => 3,
                'customer_id' => 3,
                'order_status' => 'pendiente',
                'order_date' => '2026-06-12 23:32:54',
                'order_amount' => '93100.00',
                'discount' => '0.00',
                'total' => '105203.00',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 21:07:27',
            ),
            14 => 
            array (
                'id' => 4,
                'customer_id' => 4,
                'order_status' => 'completado',
                'order_date' => '2026-06-14 23:32:54',
                'order_amount' => '270500.00',
                'discount' => '15000.00',
                'total' => '290665.00',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:54',
                'updated_at' => '2026-08-11 21:08:50',
            ),
            15 => 
            array (
                'id' => 6,
                'customer_id' => 1,
                'order_status' => 'completado',
                'order_date' => '2026-07-08 23:36:35',
                'order_amount' => '40000.00',
                'discount' => '10000.00',
                'total' => '35200.00',
                'status_id' => 1,
                'created_at' => '2026-07-18 23:36:35',
                'updated_at' => '2026-08-11 21:10:17',
            ),
            16 => 
            array (
                'id' => 7,
                'customer_id' => 2,
                'order_status' => 'completado',
                'order_date' => '2026-07-11 23:36:35',
                'order_amount' => '141250.00',
                'discount' => '5000.00',
                'total' => '154612.50',
                'status_id' => 1,
                'created_at' => '2026-07-18 23:36:35',
                'updated_at' => '2026-08-11 21:12:07',
            ),
            17 => 
            array (
                'id' => 8,
                'customer_id' => 3,
                'order_status' => 'pendiente',
                'order_date' => '2026-07-15 23:36:35',
                'order_amount' => '25000.00',
                'discount' => '0.00',
                'total' => '28250.00',
                'status_id' => 1,
                'created_at' => '2026-07-18 23:36:35',
                'updated_at' => '2026-08-11 21:12:42',
            ),
            18 => 
            array (
                'id' => 9,
                'customer_id' => 4,
                'order_status' => 'completado',
                'order_date' => '2026-07-17 23:36:35',
                'order_amount' => '325000.00',
                'discount' => '15000.00',
                'total' => '352250.00',
                'status_id' => 1,
                'created_at' => '2026-07-18 23:36:35',
                'updated_at' => '2026-08-11 21:14:17',
            ),
            19 => 
            array (
                'id' => 10,
                'customer_id' => 3,
                'order_status' => 'en proceso',
                'order_date' => '2026-07-18 23:46:52',
                'order_amount' => '530000.00',
                'discount' => '0.00',
                'total' => '598900.00',
                'status_id' => 1,
                'created_at' => '2026-07-18 23:46:52',
                'updated_at' => '2026-08-11 21:16:35',
            ),
            20 => 
            array (
                'id' => 11,
                'customer_id' => 1,
                'order_status' => 'completado',
                'order_date' => '2026-07-09 00:18:03',
                'order_amount' => '490000.00',
                'discount' => '10000.00',
                'total' => '543700.00',
                'status_id' => 1,
                'created_at' => '2026-07-19 00:18:03',
                'updated_at' => '2026-08-11 21:17:36',
            ),
            21 => 
            array (
                'id' => 12,
                'customer_id' => 2,
                'order_status' => 'completado',
                'order_date' => '2026-07-12 00:18:03',
                'order_amount' => '240000.00',
                'discount' => '5000.00',
                'total' => '266200.00',
                'status_id' => 1,
                'created_at' => '2026-07-19 00:18:03',
                'updated_at' => '2026-08-11 21:18:08',
            ),
            22 => 
            array (
                'id' => 13,
                'customer_id' => 3,
                'order_status' => 'pendiente',
                'order_date' => '2026-07-16 00:18:03',
                'order_amount' => '16000.00',
                'discount' => '0.00',
                'total' => '18080.00',
                'status_id' => 1,
                'created_at' => '2026-07-19 00:18:03',
                'updated_at' => '2026-08-11 21:18:48',
            ),
            23 => 
            array (
                'id' => 14,
                'customer_id' => 4,
                'order_status' => 'pendiente',
                'order_date' => '2026-07-18 00:18:03',
                'order_amount' => '4990.00',
                'discount' => '15000.00',
                'total' => '0.00',
                'status_id' => 1,
                'created_at' => '2026-07-19 00:18:03',
                'updated_at' => '2026-08-11 21:19:17',
            ),
            24 => 
            array (
                'id' => 15,
                'customer_id' => 1,
                'order_status' => 'completado',
                'order_date' => '2026-07-19 00:19:17',
                'order_amount' => '310000.00',
                'discount' => '0.00',
                'total' => '350300.00',
                'status_id' => 1,
                'created_at' => '2026-07-19 00:19:17',
                'updated_at' => '2026-08-11 21:19:41',
            ),
            25 => 
            array (
                'id' => 27,
                'customer_id' => 6,
                'order_status' => 'pendiente',
                'order_date' => '2026-08-11 21:49:38',
                'order_amount' => '167500.00',
                'discount' => '0.00',
                'total' => '189275.00',
                'status_id' => 7,
                'created_at' => '2026-08-11 21:49:38',
                'updated_at' => '2026-08-24 20:36:18',
            ),
            26 => 
            array (
                'id' => 33,
                'customer_id' => 1,
                'order_status' => 'en proceso',
                'order_date' => '2026-08-24 20:43:33',
                'order_amount' => '820500.00',
                'discount' => '0.00',
                'total' => '927165.00',
                'status_id' => 7,
                'created_at' => '2026-08-24 20:43:33',
                'updated_at' => '2026-08-24 20:44:39',
            ),
        ));
        
        
    }
}