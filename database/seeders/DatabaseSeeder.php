<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin principale
        User::updateOrCreate(
            ['email' => 'admin@pasticceria.it'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Impostazioni Store
        StoreSetting::updateOrCreate(
            ['store_name' => 'Pasticceria Maitardi'],
            [
                'currency' => 'EUR',
                'shipping_base_cents' => 800,
                'free_shipping_threshold_cents' => 5000,
                'is_open' => true,
            ]
        );
    }
}
