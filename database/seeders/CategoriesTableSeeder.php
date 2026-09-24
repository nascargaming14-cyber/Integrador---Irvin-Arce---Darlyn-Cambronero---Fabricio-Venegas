<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_name' => 'Césped Sintético',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            1 => 
            array (
                'id' => 2,
            'category_name' => 'Componentes de Cancha (Caucho/Arena)',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            2 => 
            array (
                'id' => 3,
                'category_name' => 'Marcos y Porterías',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            3 => 
            array (
                'id' => 4,
                'category_name' => 'Redes de Marco',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            4 => 
            array (
                'id' => 5,
                'category_name' => 'Mallas y Redes Perimetrales',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            5 => 
            array (
                'id' => 6,
                'category_name' => 'Iluminación y Reflectores LED',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            6 => 
            array (
                'id' => 7,
            'category_name' => 'Accesorios de Instalación (Goma/Pegamento)',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            7 => 
            array (
                'id' => 8,
                'category_name' => 'Herramientas de Trabajo',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            8 => 
            array (
                'id' => 9,
                'category_name' => 'Maquinaria de Mantenimiento',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            9 => 
            array (
                'id' => 10,
                'category_name' => 'Insumos de Mantenimiento y Limpieza',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            10 => 
            array (
                'id' => 11,
                'category_name' => 'Balones de Fútbol',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            11 => 
            array (
                'id' => 12,
                'category_name' => 'Chalecos y Petos',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            12 => 
            array (
                'id' => 13,
                'category_name' => 'Equipo de Seguridad y Primeros Auxilios',
                'status_id' => 1,
                'created_at' => '2026-06-15 23:32:52',
                'updated_at' => '2026-06-15 23:32:52',
            ),
            13 => 
            array (
                'id' => 16,
                'category_name' => 'Esferas',
                'status_id' => 1,
                'created_at' => '2026-08-10 23:38:24',
                'updated_at' => '2026-08-10 23:52:51',
            ),
            14 => 
            array (
                'id' => 17,
                'category_name' => 'Decorativos',
                'status_id' => 1,
                'created_at' => '2026-08-10 23:55:44',
                'updated_at' => '2026-08-10 23:55:44',
            ),
            15 => 
            array (
                'id' => 18,
                'category_name' => 'Complementos Ideales',
                'status_id' => 1,
                'created_at' => '2026-08-10 23:58:54',
                'updated_at' => '2026-08-10 23:58:54',
            ),
            16 => 
            array (
                'id' => 19,
                'category_name' => 'Follajes',
                'status_id' => 1,
                'created_at' => '2026-08-11 00:00:56',
                'updated_at' => '2026-08-11 00:00:56',
            ),
            17 => 
            array (
                'id' => 20,
                'category_name' => 'Jardines',
                'status_id' => 1,
                'created_at' => '2026-08-11 00:06:35',
                'updated_at' => '2026-08-11 00:06:35',
            ),
            18 => 
            array (
                'id' => 15,
                'category_name' => 'Césped De Colores',
                'status_id' => 1,
                'created_at' => '2026-07-27 16:23:39',
                'updated_at' => '2026-08-11 19:06:21',
            ),
            19 => 
            array (
                'id' => 21,
                'category_name' => 'Área Deportiva',
                'status_id' => 1,
                'created_at' => '2026-08-11 19:10:43',
                'updated_at' => '2026-08-11 19:10:43',
            ),
            20 => 
            array (
                'id' => 22,
                'category_name' => 'Malla Perimetrales',
                'status_id' => 1,
                'created_at' => '2026-08-11 19:23:20',
                'updated_at' => '2026-08-11 19:23:20',
            ),
        ));
        
        
    }
}