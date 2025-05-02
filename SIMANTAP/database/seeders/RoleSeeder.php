<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_role')->insert([
            ['kode_role' => 'ADM', 'nama_role' => 'Admin'],
            ['kode_role' => 'MHS', 'nama_role' => 'Mahasiswa'],
            ['kode_role' => 'DSN', 'nama_role' => 'Dosen'],
            ['kode_role' => 'TDK', 'nama_role' => 'Tendik'],
            ['kode_role' => 'SRN', 'nama_role' => 'Sarana Prasarana'],
            ['kode_role' => 'TKS', 'nama_role' => 'Teknisi'],
        ]);
    }
}
