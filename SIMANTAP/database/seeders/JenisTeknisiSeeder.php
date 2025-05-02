<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class JenisTeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_jenis_teknisi')->insert([
            [
            'nama_jenis_teknisi' => 'Software',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_jenis_teknisi' => 'Hardware',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_jenis_teknisi' => 'Jaringan',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_jenis_teknisi' => 'Umum',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
