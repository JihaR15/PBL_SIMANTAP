<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_tempat')->insert([

                // Unit Umum
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Auditorium Teknik Sipil',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Auditorium Pascasarjana',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Aula Pertamina',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Graha Polinema',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Graha Teather',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Poliklinik',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Kantin Pusat',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Gym',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Lapangan Futsal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Lapangan Minisoccer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Lapangan Basket',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Masjid Raya An-Nur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Mushola An-Nur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Gazebo Area Grapol',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Gazebo Area Gedung AX',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Gazebo Area Mushola An-Nur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Gazebo Area Gedung Akutansi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Gazebo Area Gedung AS',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
        

                // Unit Gedung Teknik Sipil
                // Lantai 5 - Timur
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 1 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 2 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 3 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 4 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 5 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 6 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 7 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPY 1 - 5T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                
                // Lantai 5 - Barat
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 1 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 2 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 3 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 4 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 5 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 6 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 7 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPY 1 - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Teknisi - 5B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Pria - LT 5',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Wanita - LT 5',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // Lantai 6 - Timur
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Baca - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Mushola JTI - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LSI 1 - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LSI 2 - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LSI 3 - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Arsip - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 2 - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 3 - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Ecosystem - 6T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // Lantai 6 - Barat
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Dosen 1 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Dosen 2 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Dosen 3 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Dosen 4 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Dosen 5 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Dosen 6 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang JTI - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Kaprodi - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Meeting Room 2 - 6B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Pria - LT 6',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Wanita - LT 6',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],            

                // Lantai 7 - Timur
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 8 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LIG 1 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LIG 2 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LKJ 2 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LKJ 3 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LERP - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPY 4 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LAI 1 - 7T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // Lantai 7 - Barat
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 1 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 2 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 3 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 4 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 5 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 6 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LPR 7 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LKJ 1 - 7B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Pria - LT 7',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Wanita - LT 7',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // Lantai 8 - Timur
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Kantin JTI - 8T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 12 - 8T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 13 - 8T',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                
                // Lantai 8 - Barat
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 8 - 8B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 9 - 8B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 10 - 8B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'RT 11 - 8B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'LAI 2 - 8B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Ruang Studio - 8B',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Pria - LT 8',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '2',
                    'nama_tempat' => 'Toilet Wanita - LT 8',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Tempat Parkir Belakang Gedung AS',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Tempat Parkir Depan Gedung AS',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Tempat Parkir Belakang Aula Pertamina',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Tempat Parkir Gedung AX',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'unit_id' => '1',
                    'nama_tempat' => 'Tempat Parkir Basement Graha Polinema',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
        ]);
    }
}