<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_fasilitas')->insert([
            [
            'nama_fasilitas' => 'Fasilitas Gedung',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_fasilitas' => 'Faslitas Umum',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
