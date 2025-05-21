<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_bobot')->insert([
            [
                'nama_parameter' => 'Tingkat Kerusakan',
                'bobot' => 0.25
            ],
            [
                'nama_parameter' => 'Dampak Terhadap Aktivitas Akademik',
                'bobot' => 0.20
            ],
            [
                'nama_parameter' => 'Frekuensi Penggunaan Fasilitas',
                'bobot' => 0.20
            ],
            [
                'nama_parameter' => 'Ketersediaan Barang Pengganti',
                'bobot' => 0.15
            ],
            [
                'nama_parameter' => 'Tingkat Resiko Keselamatan',
                'bobot' => 0.20
            ],
        ]);
    }
}