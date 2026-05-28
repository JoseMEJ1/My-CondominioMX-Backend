<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departamentos')->insert([
            [
                'depa' => 'A-101',
                'moroso' => false,
                'codigo' => 'A101'
            ],
            [
                'depa' => 'A-102',
                'moroso' => false,
                'codigo' => 'A102'
            ],
            [
                'depa' => 'B-201',
                'moroso' => true,
                'codigo' => 'B201'
            ]
        ]);
    }
}