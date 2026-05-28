<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {

        Usuario::create([

            'id_persona' => 1,

            'correo' => 'mani@gmail.com',

            'password' => Hash::make('12345678'),

            'admin' => true
        ]);

        Usuario::create([

            'id_persona' => 2,

            'correo' => 'usuario@gmail.com',

            'password' => Hash::make('12345678'),

            'admin' => false
        ]);
    }
}