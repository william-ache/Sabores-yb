<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sabores.com'],
            [
                'name' => 'Admin Sabores',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
