<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            [
                'user_name' => 'Administrador',
                'email' => 'admin@integrador.com',
                'telephone' => '88880001',
                'password' => Hash::make('Admin123'),
                'role_id' => 1,
                'status_id' => 1
            ],

            [
                'user_name' => 'Ventas',
                'email' => 'ventas@integrador.com',
                'telephone' => '88880002',
                'password' => Hash::make('Ventas123'),
                'role_id' => 2,
                'status_id' => 1
            ],

            [
                'user_name' => 'Bodega',
                'email' => 'bodega@integrador.com',
                'telephone' => '88880003',
                'password' => Hash::make('Bodega123'),
                'role_id' => 3,
                'status_id' => 1
            ]

        ];

        foreach ($users as $user) {

            User::firstOrCreate(
                [
                    'email' => $user['email']
                ],
                $user
            );

        }
    }
}