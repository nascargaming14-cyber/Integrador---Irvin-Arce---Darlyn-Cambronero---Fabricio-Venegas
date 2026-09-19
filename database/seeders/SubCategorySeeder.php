<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [

            // 1. Césped Sintético (Category ID = 1)
            ['Césped 20 mm', 1],
            ['Césped 30 mm', 1],
            ['Césped 40 mm', 1],
            ['Césped 50 mm', 1],
            ['Césped Monoflamento profesional', 1],

            // 2. Componentes de Cancha (Caucho/Arena) (Category ID = 2)
            ['Caucho Criogénico / Granulado', 2],
            ['Arena de Sílice', 2],

            // 3. Marcos y Porterías (Category ID = 3)
            ['Marcos Fútbol 5', 3],
            ['Marcos Fútbol 7 / 8', 3],
            ['Marcos Fútbol 11 (Reglamentarios)', 3],
            ['Marcos Portátiles / Entrenamiento', 3],

            // 4. Redes de Marco (Category ID = 4)
            ['Redes de Nylon Alta Densidad', 4],
            ['Redes de Polipropileno', 4],

            // 5. Mallas y Redes Perimetrales (Category ID = 5)
            ['Malla de Polietileno (Techado/Fondo)', 5],
            ['Malla Ciclónica (Estructural)', 5],

            // 6. Iluminación y Electricidad (Category ID = 6)
            ['Reflectores LED 200W', 6],
            ['Reflectores LED 400W', 6],
            ['Cableado y Breakers', 6],

            // 7. Accesorios de Instalación (Category ID = 7)
            ['Pegamento de Poliuretano', 7],
            ['Cintas de Unión', 7],
            ['Clavos / Grapas de Fijación', 7],
            ['Malla Geotextil', 7],

            // 8. Herramientas de Trabajo (Category ID = 8)
            ['Cuchillas y Cúters', 8],
            ['Espátulas Dentadas', 8],
            ['Flexómetros y Cintas Métricas', 8],

            // 9. Maquinaria de Mantenimiento (Category ID = 9)
            ['Máquina Peinadora / Cepilladora', 9],
            ['Sopladoras de Hojas', 9],
            ['Remolcadores de Arena', 9],

            // 10. Insumos de Mantenimiento y Limpieza (Category ID = 10)
            ['Limpiadores Líquidos', 10],
            ['Desinfectantes / Sanitizantes', 10],
            ['Eliminadores de Olores', 10],

            // 11. Balones de Fútbol (Category ID = 11)
            ['Balones #4 (Fútbol Sala / Niños)', 11],
            ['Balones #5 (Fútbol 7 y 11)', 11],

            // 12. Chalecos y Petos (Category ID = 12)
            ['Petos Infantiles', 12],
            ['Petos Adultos (Tallas M/L/XL)', 12],

            // 13. Equipo de Seguridad y Primeros Auxilios (Category ID = 13)
            ['Botiquín de Emergencias', 13],
            ['Extintores', 13]

        ];

        foreach ($subcategories as $subcategory) {

            SubCategory::firstOrCreate(
                [
                    'subcategory_name' => $subcategory[0],
                    'category_id'      => $subcategory[1]
                ],
                [
                    'status_id' => 1
                ]
            );

        }
    }
}