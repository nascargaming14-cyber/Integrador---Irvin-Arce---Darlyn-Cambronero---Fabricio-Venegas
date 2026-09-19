<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSupplier;

class ProductSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $relations = [

            // GreenFields CR
            ['product_id' => 1, 'supplier_id' => 1],
            ['product_id' => 2, 'supplier_id' => 1],

            // EcoGrass Solutions
            ['product_id' => 3, 'supplier_id' => 2],
            ['product_id' => 4, 'supplier_id' => 2],

            // TurfMaster
            ['product_id' => 5, 'supplier_id' => 3],
            ['product_id' => 6, 'supplier_id' => 2],

            // Césped Premium
            ['product_id' => 1, 'supplier_id' => 1],
            ['product_id' => 3, 'supplier_id' => 3],

            // Importadora Deportiva CR
            ['product_id' => 7, 'supplier_id' => 1],
            ['product_id' => 8, 'supplier_id' => 1],
            ['product_id' => 9, 'supplier_id' => 2],
            ['product_id' => 10, 'supplier_id' => 3],
            ['product_id' => 11, 'supplier_id' => 3],

        ];

        foreach ($relations as $relation) {

            ProductSupplier::firstOrCreate(
                [
                    'product_id'  => $relation['product_id'],
                    'supplier_id' => $relation['supplier_id']
                ],
                [
                    'status_id' => 1
                ]
            );

        }
    }
}