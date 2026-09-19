<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [

            [
                'customer_name' => 'Constructora San Carlos',
                'dni' => '310123456',
                'email' => 'compras@constructorasc.com',
                'telephone' => '8888-1111'
            ],

            [
                'customer_name' => 'Complejo Deportivo Norte',
                'dni' => '310654321',
                'email' => 'administracion@deportivonorte.com',
                'telephone' => '8888-2222'
            ],

            [
                'customer_name' => 'Municipalidad Local',
                'dni' => '310789456',
                'email' => 'proveeduria@municipalidad.go.cr',
                'telephone' => '8888-3333'
            ],

            [
                'customer_name' => 'Jardines Tropicales',
                'dni' => '310987654',
                'email' => 'ventas@jardinestropicales.com',
                'telephone' => '8888-4444'
            ]

        ];

        foreach ($customers as $customer) {

            Customer::firstOrCreate(
                [
                    'customer_name' => $customer['customer_name']
                ],
                [
                    'dni' => $customer['dni'],
                    'email' => $customer['email'],
                    'telephone' => $customer['telephone'],
                    'status_id' => 1
                ]
            );

        }
    }
}