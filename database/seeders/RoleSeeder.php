<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Status;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $activo = Status::where('status_name', 'Activo')->first()
            ?? Status::create(['status_name' => 'Activo']);

        $roles = [
            'Administrador',
            'Ventas',
            'Supervisor de Ventas',
            'Bodega',
            'Compras',
            'Gerencia',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(
                ['role_name' => $roleName],
                ['status_id' => $activo->id]
            );
        }
    }
}