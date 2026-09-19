<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            [
                'barcode' => 'CSP20001',
                'product_name' => 'Cesped Sintetico 20 mm',
                'stock' => 150,
                'minimum_stock' => 20,
                'price_sale' => 12500,
                'price_buy' => 9000,
                'sub_category_id' => 1,
                'unit_id' => 1,
                'status_id' => 1
            ],

            [
                'barcode' => 'CSP30001',
                'product_name' => 'Cesped Sintetico 30 mm',
                'stock' => 120,
                'minimum_stock' => 15,
                'price_sale' => 16500,
                'price_buy' => 12000,
                'sub_category_id' => 2,
                'unit_id' => 1,
                'status_id' => 1
            ],

            [
                'barcode' => 'CSP40001',
                'product_name' => 'Cesped Sintetico 40 mm',
                'stock' => 100,
                'minimum_stock' => 15,
                'price_sale' => 19500,
                'price_buy' => 14500,
                'sub_category_id' => 3,
                'unit_id' => 1,
                'status_id' => 1
            ],

            [
                'barcode' => 'CSP50001',
                'product_name' => 'Cesped Sintetico 50 mm',
                'stock' => 80,
                'minimum_stock' => 10,
                'price_sale' => 22500,
                'price_buy' => 17000,
                'sub_category_id' => 4,
                'unit_id' => 1,
                'status_id' => 1
            ],

            [
                'barcode' => 'PEG001',
                'product_name' => 'Pegamento Profesional 4L',
                'stock' => 50,
                'minimum_stock' => 10,
                'price_sale' => 18500,
                'price_buy' => 13000,
                'sub_category_id' => 5,
                'unit_id' => 2,
                'status_id' => 1
            ],

            [
                'barcode' => 'CTU001',
                'product_name' => 'Cinta de Union 30m',
                'stock' => 80,
                'minimum_stock' => 15,
                'price_sale' => 9500,
                'price_buy' => 6000,
                'sub_category_id' => 6,
                'unit_id' => 2,
                'status_id' => 1
            ],

            [
                'barcode' => 'CLA001',
                'product_name' => 'Clavo Galvanizado',
                'stock' => 500,
                'minimum_stock' => 100,
                'price_sale' => 150,
                'price_buy' => 80,
                'sub_category_id' => 7,
                'unit_id' => 3,
                'status_id' => 1
            ],

            [
                'barcode' => 'MGE001',
                'product_name' => 'Malla Geotextil',
                'stock' => 75,
                'minimum_stock' => 10,
                'price_sale' => 7500,
                'price_buy' => 5000,
                'sub_category_id' => 8,
                'unit_id' => 1,
                'status_id' => 1
            ],

            [
                'barcode' => 'CUC001',
                'product_name' => 'Cuchilla Profesional',
                'stock' => 30,
                'minimum_stock' => 5,
                'price_sale' => 8500,
                'price_buy' => 5500,
                'sub_category_id' => 9,
                'unit_id' => 2,
                'status_id' => 1
            ],

            [
                'barcode' => 'CEP001',
                'product_name' => 'Cepillo para Cesped',
                'stock' => 20,
                'minimum_stock' => 5,
                'price_sale' => 22000,
                'price_buy' => 16000,
                'sub_category_id' => 10,
                'unit_id' => 2,
                'status_id' => 1
            ],

            [
                'barcode' => 'ASI001',
                'product_name' => 'Arena Silica Premium',
                'stock' => 200,
                'minimum_stock' => 30,
                'price_sale' => 4500,
                'price_buy' => 2500,
                'sub_category_id' => 13,
                'unit_id' => 4,
                'status_id' => 1
            ]

        ];

        foreach ($products as $product) {

            Product::firstOrCreate(
                [
                    'barcode' => $product['barcode']
                ],
                $product
            );

        }
    }
}