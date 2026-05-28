<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            TiposPagoSeeder::class,
            MotivosSeeder::class,
            PersonaSeeder::class,
            UsuarioSeeder::class,
            DepartamentoSeeder::class,
        ]);
    }
}