<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_users')->insert([
            [
                'role_id' => 2, // mahasiswa
                'username' => 'mahasiswa1',
                'name' => 'Mahasiswa Satu',
                'password' => Hash::make('password'),
                'foto_profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 6, // teknisi
                'username' => 'teknisi1',
                'name' => 'Teknisi Hardware',
                'password' => Hash::make('password'),
                'foto_profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 6, // teknisi
                'username' => 'teknisi2',
                'name' => 'Teknisi Software',
                'password' => Hash::make('password'),
                'foto_profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 1, // admin
                'username' => 'Admin1',
                'name' => 'Admin Satu',
                'password' => Hash::make('password'),
                'foto_profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 5, // sarana
                'username' => 'sarpras1',
                'name' => 'Petugas Sarpras',
                'password' => Hash::make('password'),
                'foto_profile' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
