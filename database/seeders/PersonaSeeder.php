<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('personas')->insert([
            [
                'nombre' => 'Jose Manuel',
                'apellido_p' => 'Estrada',
                'apellido_m' => 'Jimenez',
                'celular' => '3312345678',
                'activo' => true
            ]
        ]);
        DB::table('personas')->insert([
            [
                'nombre' => 'Celeste Judith',
                'apellido_p' => 'Padilla',
                'apellido_m' => 'Mora',
                'celular' => '3312345678',
                'activo' => true
            ]
        ]);
    }
}