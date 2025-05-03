<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_unit')->insert([
            [
                'fasilitas_id' => 2, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung Teknik Sipil', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung Teknik Mesin', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AB', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AC', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AD', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AE', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AF', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AG', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AH', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AI', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AJ', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AK', 
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AL', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AN', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AO', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AP', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AQ', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AS', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AT', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AU', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'fasilitas_id' => 1, // ada di tabel m_fasilitas (id 1 = Gedung, id 2 = Umum)
                'nama_unit' => 'Gedung AW', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}
