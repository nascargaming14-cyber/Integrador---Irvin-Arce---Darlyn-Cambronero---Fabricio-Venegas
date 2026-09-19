<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Infraestructura y Superficie
            'Césped Sintético',
            'Componentes de Cancha (Caucho/Arena)',
            
            // Equipamiento Fijo y Estructuras
            'Marcos y Porterías',
            'Redes de Marco',
            'Mallas y Redes Perimetrales',
            
            // Iluminación y Electricidad
            'Iluminación y Reflectores LED',
            
            // Materiales de Instalación
            'Accesorios de Instalación (Goma/Pegamento)',
            
            // Herramientas y Maquinaria
            'Herramientas de Trabajo',
            'Maquinaria de Mantenimiento',
            
            // Cuidado y Limpieza
            'Insumos de Mantenimiento y Limpieza',
            
            // Implementos Deportivos (Alquiler o Uso)
            'Balones de Fútbol',
            'Chalecos y Petos',
            
            // Seguridad y Primeros Auxilios
            'Equipo de Seguridad y Primeros Auxilios'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                [
                    'category_name' => $category
                ],
                [
                    'status_id' => 1
                ]
            );
        }
    }
}