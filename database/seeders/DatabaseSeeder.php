<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TrainingCenter;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {


        User::factory()->create([
            'name'     => 'Administrador ADMISENA',
            'email'    => 'admin@sena.edu.co',
            'password' => Hash::make('admin123'),

        ]);

        TrainingCenter::firstOrCreate([
            'name' => 'Centro de Comercio y Servicios',
        ], [
            'address' => 'Calle 4 No. 2-80, Barrio Centro - Popayán, Cauca',
        ]);
    }
}
