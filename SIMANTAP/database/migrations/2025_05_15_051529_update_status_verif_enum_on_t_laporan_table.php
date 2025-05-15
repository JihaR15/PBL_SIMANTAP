<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('t_laporan', function (Blueprint $table) {
            // Drop kolom dulu (pastikan backup data jika perlu)
            $table->dropColumn('status_verif');
        });

        Schema::table('t_laporan', function (Blueprint $table) {
            // Buat ulang kolom dengan enum baru yang ditambahkan 'ditolak'
            $table->enum('status_verif', ['belum diverifikasi', 'diverifikasi', 'ditolak'])
                    ->default('belum diverifikasi')
                    ->after('kategori_kerusakan_id');
        });
    }

    public function down()
    {
        Schema::table('t_laporan', function (Blueprint $table) {
            $table->dropColumn('status_verif');
        });

        Schema::table('t_laporan', function (Blueprint $table) {
            $table->enum('status_verif', ['belum diverifikasi', 'diverifikasi'])
                    ->default('belum diverifikasi')
                    ->after('kategori_kerusakan_id');
        });
    }
};
