<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelKerusakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_level_kerusakan')->insert([
            [
                'nama_level_kerusakan' => 'Rusak Ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_level_kerusakan' => 'Rusak Sedang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_level_kerusakan' => 'Rusak Berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
