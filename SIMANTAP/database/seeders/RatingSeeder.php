<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_rating')->insert([
            [
                'keterangan' => 'Sangat Kurang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keterangan' => 'Kurang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keterangan' => 'Cukup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keterangan' => 'Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keterangan' => 'Sangat Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
