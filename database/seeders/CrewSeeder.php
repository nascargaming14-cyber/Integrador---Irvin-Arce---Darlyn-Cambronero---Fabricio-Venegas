<?php

namespace Database\Seeders;

use App\Models\Crew;
use Illuminate\Database\Seeder;

class CrewSeeder extends Seeder
{
    /**
     * Cuadrillas en el orden y con las letras exactas de la pizarra original.
     * "code" es único internamente aunque "label" (lo que se ve) se repita.
     * Ajusta el "name" de cada una al nombre real (camión, cuadrilla, etc.).
     */
    public function run(): void
    {
        $crews = [
            ['code' => 'C',  'label' => 'C', 'sort_order' => 1, 'name' => null],
            ['code' => 'J',  'label' => 'J', 'sort_order' => 2, 'name' => null],
            ['code' => 'A1', 'label' => 'A', 'sort_order' => 3, 'name' => null],
            ['code' => 'V',  'label' => 'V', 'sort_order' => 4, 'name' => null],
            ['code' => 'A2', 'label' => 'A', 'sort_order' => 5, 'name' => null],
            ['code' => 'W',  'label' => 'W', 'sort_order' => 6, 'name' => null],
        ];

        foreach ($crews as $crew) {
            Crew::updateOrCreate(['code' => $crew['code']], $crew);
        }
    }
}
