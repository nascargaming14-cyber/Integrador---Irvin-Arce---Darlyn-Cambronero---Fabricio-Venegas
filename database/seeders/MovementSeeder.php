<?php

namespace Database\Seeders;

use App\Models\Movement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MovementSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users    = User::all();

        if ($products->isEmpty()) {
            $this->command->warn('No hay productos: corre ProductSeeder antes que MovementSeeder.');
            return;
        }

        $tipos = ['entrada', 'salida'];

        // Genera entre 3 y 6 movimientos por semana durante las últimas 6 semanas
        for ($semana = 5; $semana >= 0; $semana--) {
            $inicioSemana = Carbon::now()->subWeeks($semana)->startOfWeek();
            $cantidadMovimientos = rand(3, 6);

            for ($i = 0; $i < $cantidadMovimientos; $i++) {
                Movement::create([
                    'product_id'  => $products->random()->id,
                    'type'        => $tipos[array_rand($tipos)],
                    'quantity'    => rand(5, 200),
                    'user_id'     => $users->isNotEmpty() ? $users->random()->id : null,
                    'description' => null,
                    'created_at'  => $inicioSemana->copy()->addDays(rand(0, 6))->addHours(rand(8, 18)),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}