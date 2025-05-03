<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_jenis_barang')->insert([
            [
                'nama_barang' => 'AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Proyektor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Kabel Proyektor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'LCD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'PC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Access Point',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Kabel Jaringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Stop Kontak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Socket LAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Lampu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Saklar Lampu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Jaringan Internet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Kursi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Papan Tulis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
