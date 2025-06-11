<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaporanModel;

class LaporanVerifikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = [5, 8]; // ini diganti user_id nya sarpras #gilang

        LaporanModel::all()->each(function ($laporan) use ($userIds) {
            $laporan->verifikator_id = $userIds[array_rand($userIds)];
            $laporan->save();
        });
    }
}
