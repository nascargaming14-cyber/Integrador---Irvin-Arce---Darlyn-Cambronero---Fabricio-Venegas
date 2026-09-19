<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use App\Models\UnitMeasurement;
use Illuminate\Database\Seeder;

class SubCategoryUnitMeasurementSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'Césped 20 mm'                          => ['Metro cuadrado', 'Rollo'],
            'Césped 30 mm'                           => ['Metro cuadrado', 'Rollo'],
            'Césped 40 mm'                           => ['Metro cuadrado', 'Rollo'],
            'Césped 50 mm'                           => ['Metro cuadrado', 'Rollo'],
            'Césped Monoflamento profesional'        => ['Metro cuadrado', 'Rollo'],
            'Caucho Criogénico / Granulado'          => ['Kilogramo', 'Saco'],
            'Arena de Sílice'                        => ['Kilogramo', 'Saco'],
            'Marcos Fútbol 5'                        => ['Unidad'],
            'Marcos Fútbol 7 / 8'                    => ['Unidad'],
            'Marcos Fútbol 11 (Reglamentarios)'      => ['Unidad'],
            'Marcos Portátiles / Entrenamiento'      => ['Unidad'],
            'Redes de Nylon Alta Densidad'           => ['Unidad', 'Metro'],
            'Redes de Polipropileno'                 => ['Unidad', 'Metro'],
            'Malla de Polietileno (Techado/Fondo)'   => ['Metro cuadrado', 'Rollo'],
            'Malla Ciclónica (Estructural)'          => ['Metro cuadrado', 'Rollo'],
            'Reflectores LED 200W'                   => ['Unidad'],
            'Reflectores LED 400W'                   => ['Unidad'],
            'Cableado y Breakers'                    => ['Metro', 'Unidad'],
            'Pegamento de Poliuretano'                => ['Litro', 'Galón', 'Tubo'],
            'Cintas de Unión'                        => ['Rollo', 'Metro'],
            'Clavos / Grapas de Fijación'            => ['Caja', 'Kilogramo'],
            'Malla Geotextil'                        => ['Metro cuadrado', 'Rollo'],
            'Cuchillas y Cúters'                     => ['Unidad'],
            'Espátulas Dentadas'                     => ['Unidad'],
            'Flexómetros y Cintas Métricas'          => ['Unidad'],
            'Máquina Peinadora / Cepilladora'        => ['Unidad'],
            'Sopladoras de Hojas'                    => ['Unidad'],
            'Remolcadores de Arena'                  => ['Unidad'],
            'Limpiadores Líquidos'                   => ['Litro', 'Galón'],
            'Desinfectantes / Sanitizantes'          => ['Litro', 'Galón'],
            'Eliminadores de Olores'                 => ['Litro', 'Frasco'],
            'Balones #4 (Fútbol Sala / Niños)'       => ['Unidad', 'Docena'],
            'Balones #5 (Fútbol 7 y 11)'             => ['Unidad', 'Docena'],
            'Petos Infantiles'                       => ['Unidad', 'Par'],
            'Petos Adultos (Tallas M/L/XL)'          => ['Unidad', 'Par'],
            'Botiquín de Emergencias'                => ['Unidad', 'Kit'],
            'Extintores'                             => ['Unidad'],
        ];

        foreach ($mapping as $subCategoryName => $unitNames) {
            $subCategory = SubCategory::where('subcategory_name', $subCategoryName)->first();

            if (! $subCategory) {
                $this->command->warn("Subcategoría no encontrada: {$subCategoryName}");
                continue;
            }

            $unitIds = UnitMeasurement::whereIn('unit_name', $unitNames)->pluck('id');

            if ($unitIds->count() !== count($unitNames)) {
                $found = UnitMeasurement::whereIn('unit_name', $unitNames)->pluck('unit_name')->toArray();
                $missing = array_diff($unitNames, $found);
                $this->command->warn("Unidades no encontradas para '{$subCategoryName}': " . implode(', ', $missing));
            }

            $subCategory->allowedUnits()->sync($unitIds);
        }

        $this->command->info('Relaciones subcategoría-unidad sincronizadas.');
    }
}