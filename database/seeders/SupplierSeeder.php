<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            'Guatemala',
            'Brasil',
            'Japón'
        ];

        foreach ($suppliers as $supplier) {

            Supplier::firstOrCreate(
                [
                    'name' => $supplier
                ],
                [
                    'status_id' => 1
                ]
            );

        }
    }
}