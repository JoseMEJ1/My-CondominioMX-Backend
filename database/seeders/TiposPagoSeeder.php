<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposPagoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_pago')->insert([
            ['tipo' => 'Transferencia'],
            ['tipo' => 'Efectivo'],
            ['tipo' => 'Tarjeta']
        ]);
    }
}