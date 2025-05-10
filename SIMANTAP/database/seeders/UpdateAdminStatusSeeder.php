<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateAdminStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update status pengguna dengan username 'admin1' menjadi 1
        DB::table('m_users')
            ->where('username', 'Admin1')
            ->update(['status' => 1]);

        $this->command->info('Status admin1 berhasil diperbarui menjadi 1.');
    }
}
