<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_teknisi')->insert([
            [
                'user_id' => 2, // ada di tabel m_users
                'jenis_teknisi_id' => 2, // ada di tabel m_jenis_teknisi
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'jenis_teknisi_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
