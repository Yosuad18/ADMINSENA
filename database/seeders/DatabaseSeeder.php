<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}
