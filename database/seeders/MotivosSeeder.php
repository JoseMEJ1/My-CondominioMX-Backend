<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('motivos')->insert([
            ['motivo' => 'Mantenimiento'],
            ['motivo' => 'Multa'],
            ['motivo' => 'Evento'],
            ['motivo' => 'Otro']
        ]);
    }
}