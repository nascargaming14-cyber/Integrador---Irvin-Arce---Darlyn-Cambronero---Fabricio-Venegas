<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeaderOrder;

class HeaderOrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [

            [
                'customer_id' => 1,
                'order_status' => 'COMPLETADA',
                'order_date' => now()->subDays(10),
                'order_amount' => 250000,
                'discount' => 10000,
                'total' => 240000,
                'status_id' => 1
            ],

            [
                'customer_id' => 2,
                'order_status' => 'COMPLETADA',
                'order_date' => now()->subDays(7),
                'order_amount' => 175000,
                'discount' => 5000,
                'total' => 170000,
                'status_id' => 1
            ],

            [
                'customer_id' => 3,
                'order_status' => 'PENDIENTE',
                'order_date' => now()->subDays(3),
                'order_amount' => 98000,
                'discount' => 0,
                'total' => 98000,
                'status_id' => 1
            ],

            [
                'customer_id' => 4,
                'order_status' => 'COMPLETADA',
                'order_date' => now()->subDay(),
                'order_amount' => 315000,
                'discount' => 15000,
                'total' => 300000,
                'status_id' => 1
            ]

        ];

        foreach ($orders as $order) {

            HeaderOrder::firstOrCreate(
                [
                    'customer_id' => $order['customer_id'],
                    'order_date' => $order['order_date']
                ],
                $order
            );

        }
    }
}