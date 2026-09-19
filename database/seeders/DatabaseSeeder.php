<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            RoleSeeder::class,
            UnitMeasurementSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            ProductSupplierSeeder::class,
            HeaderOrderSeeder::class,
            OrderDetailSeeder::class,
            SubCategoryUnitMeasurementSeeder::class,
            MovementSeeder::class
        ]);
    }
}