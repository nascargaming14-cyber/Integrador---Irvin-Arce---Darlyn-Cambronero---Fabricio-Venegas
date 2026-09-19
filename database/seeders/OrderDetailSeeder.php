<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $details = [

            // Orden #1
            [
                'header_order_id' => 1,
                'product_id' => 1,
                'quantity' => 25,
                'barcode' => '770100001',
                'product_name' => 'Césped Sintético Premium 35mm',
                'price' => 8500,
                'subtotal' => 212500,
                'iva' => 27625,
                'status_id' => 1
            ],

            [
                'header_order_id' => 1,
                'product_id' => 2,
                'quantity' => 5,
                'barcode' => '770100002',
                'product_name' => 'Césped Sintético Deportivo 50mm',
                'price' => 7500,
                'subtotal' => 37500,
                'iva' => 4875,
                'status_id' => 1
            ],

            // Orden #2
            [
                'header_order_id' => 2,
                'product_id' => 3,
                'quantity' => 15,
                'barcode' => '770100003',
                'product_name' => 'Césped Decorativo 25mm',
                'price' => 6500,
                'subtotal' => 97500,
                'iva' => 12675,
                'status_id' => 1
            ],

            [
                'header_order_id' => 2,
                'product_id' => 4,
                'quantity' => 10,
                'barcode' => '770100004',
                'product_name' => 'Cinta de Unión',
                'price' => 7000,
                'subtotal' => 70000,
                'iva' => 9100,
                'status_id' => 1
            ],

            // Orden #3
            [
                'header_order_id' => 3,
                'product_id' => 5,
                'quantity' => 20,
                'barcode' => '770100005',
                'product_name' => 'Pegamento Especial',
                'price' => 4900,
                'subtotal' => 98000,
                'iva' => 12740,
                'status_id' => 1
            ],

            // Orden #4
            [
                'header_order_id' => 4,
                'product_id' => 1,
                'quantity' => 30,
                'barcode' => '770100001',
                'product_name' => 'Césped Sintético Premium 35mm',
                'price' => 8500,
                'subtotal' => 255000,
                'iva' => 33150,
                'status_id' => 1
            ],

            [
                'header_order_id' => 4,
                'product_id' => 3,
                'quantity' => 10,
                'barcode' => '770100003',
                'product_name' => 'Césped Decorativo 25mm',
                'price' => 6000,
                'subtotal' => 60000,
                'iva' => 7800,
                'status_id' => 1
            ]
        ];

        foreach ($details as $detail) {

            OrderDetail::firstOrCreate(
                [
                    'header_order_id' => $detail['header_order_id'],
                    'product_id' => $detail['product_id']
                ],
                $detail
            );

        }
    }
}