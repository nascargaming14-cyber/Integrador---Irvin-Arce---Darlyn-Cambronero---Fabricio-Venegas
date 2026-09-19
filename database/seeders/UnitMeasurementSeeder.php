<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\UnitMeasurement;
class UnitMeasurementSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            // Masa / Peso
            'Miligramo',
            'Gramo',
            'Kilogramo',
            'Tonelada',
            'Libra',
            'Onza',
            // Volumen / Líquidos
            'Mililitro',
            'Litro',
            'Galón',
            'Centilitro',
            'Barril',
            // Longitud
            'Milímetro',
            'Centímetro',
            'Metro',
            'Kilómetro',
            'Pulgada',
            'Pie',
            'Yarda',
            // Área
            'Metro cuadrado',
            'Centímetro cuadrado',
            'Hectárea',
            'Pie cuadrado',
            // Empaque / Conteo
            'Unidad',
            'Par',
            'Docena',
            'Caja',
            'Paquete',
            'Fardo',
            'Bulto',
            'Saco',
            'Rollo',
            'Bolsa',
            'Paleta',
            'Contenedor',
            'Juego',
            'Kit',
            'Lote',
            // Tiempo
            'Hora',
            'Día',
            'Semana',
            'Mes',
            // Energía / Tecnología
            'Kilovatio',
            'Kilovatio-hora',
            'Megabyte',
            'Gigabyte',
            // Otros
            'Porción',
            'Servicio',
            'Pieza',
            'Tubo',
            'Frasco',
            'Lata',
            'Ampolla',
        ];

        foreach ($units as $unit) {
            UnitMeasurement::firstOrCreate(
                [
                    'unit_name' => $unit
                ],
                [
                    'status_id' => 1
                ]
            );
        }
    }
}