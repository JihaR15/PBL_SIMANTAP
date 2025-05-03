<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_periode')->insert([
            [
                'nama_periode' => '2024',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_periode' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_periode' => '2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_periode' => '2027',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
