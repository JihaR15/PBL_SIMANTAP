<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangLokasiData = [
            // Unit Umum
            1 => [1, 2, 3, 4],
            2 => [1, 2, 3, 4],
            3 => [1, 2, 3, 4, 5],
            4 => [1, 2, 3, 4, 5],
            5 => [1, 2, 3, 4],
            6 => [6, 7],
            7 => [7, 8],
            8 => [1, 4, 5],
            9 => [7, 8, 9],
            10 => [7, 8, 9],
            11 => [7, 8, 9],
            12 => [6, 7],
            13 => [6, 7],
            14 => [7, 8],
            15 => [7, 8, 9],
            16 => [7, 8],
            17 => [7, 8, 9],
            18 => [7, 8],

            // Unit Gedung Teknik Sipil
            // Lantai 5 - Timur
            19 => [1, 2, 3, 4],
            20 => [1, 2, 3, 4],
            21 => [1, 2, 3],
            22 => [2, 4, 5],
            23 => [2, 4, 6],
            24 => [2, 6, 7],
            25 => [3, 4, 7],
            26 => [3, 5],

            // Lantai 5 - Barat
            27 => [1, 3, 5],
            28 => [1, 4, 6],
            29 => [2, 4, 7],
            30 => [2, 5, 7],
            31 => [1, 6, 8],
            32 => [6, 7, 8],
            33 => [7, 8, 9],
            34 => [3, 5, 9],

            // Lantai 6 - Timur
            35 => [1, 2, 3, 4],
            36 => [1, 2, 5],
            37 => [6, 7],
            38 => [2, 3],
            39 => [6, 7],
            40 => [6, 8],

            // Lantai 6 - Barat
            41 => [1, 2],
            42 => [7, 9],
            43 => [6, 9],
            44 => [3, 4],
            45 => [1, 8],
            46 => [7, 9],

            // Lantai 7 - Timur
            47 => [1, 2, 3],
            48 => [6, 8],
            49 => [2, 5],
            50 => [3, 7],
            51 => [1, 6],
            52 => [2, 4],

            // Lantai 7 - Barat
            53 => [5, 8],
            54 => [4, 7],
            55 => [1, 2],
            56 => [3, 6],
            57 => [7, 9],
            58 => [6, 5],

            // Lantai 8 - Timur
            59 => [1, 4, 6],
            60 => [3, 5],
            61 => [6, 7],

            // Lantai 8 - Barat
            62 => [4, 5],
            63 => [2, 7],
            64 => [6, 8]
        ];

        foreach ($barangLokasiData as $tempat_id => $jenis_barang_ids) {
            foreach ($jenis_barang_ids as $jenis_barang_id) {
                DB::table('m_barang_lokasi')->insert([
                    'tempat_id' => $tempat_id,
                    'jenis_barang_id' => $jenis_barang_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "Barang Lokasi seeding completed!";
    }
}
