<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Activo',
            'Inactivo',
            'Eliminado',
            'Disponible',
            'Descontinuado',
            'Agotado',
            'En revisión',
            'Pendiente',
            'Completado',
            'Cancelado',
            'Rechazado',
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate([
                'status_name' => $status
            ]);
        }
    }
}