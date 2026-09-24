<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StatusTableSeeder::class,
            RolesTableSeeder::class,
            UnitMeasurementTableSeeder::class,
            CategoriesTableSeeder::class,
            SubCategoriesTableSeeder::class,
            SubCategoryUnitMeasurementTableSeeder::class,
            SuppliersTableSeeder::class,
            CustomersTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            ProductSuppliersTableSeeder::class,
            HeaderOrdersTableSeeder::class,
            OrderDetailsTableSeeder::class,
            MovementsTableSeeder::class,
        ]);

        // Arreglar las secuencias de PostgreSQL
        foreach ([
            'status', 'roles', 'unit_measurement', 'categories',
            'sub_categories', 'suppliers', 'customers', 'users',
            'products', 'product_suppliers', 'header_orders',
            'order_details', 'movements',
        ] as $tabla) {
            DB::statement("SELECT setval(pg_get_serial_sequence('$tabla', 'id'), COALESCE((SELECT MAX(id) FROM $tabla), 1))");
        }
    }
}
