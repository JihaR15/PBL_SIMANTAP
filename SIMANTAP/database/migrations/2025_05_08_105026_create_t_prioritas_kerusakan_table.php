<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_prioritas_kerusakan', function (Blueprint $table) {
            $table->id('prioritas_kerusakan_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('tingkat_kerusakan_id');
            $table->unsignedBigInteger('dampak_terhadap_aktivitas_akademik_id');
            $table->unsignedBigInteger('frekuensi_penggunaan_fasilitas_id');
            $table->unsignedBigInteger('ketersediaan_barang_pengganti_id');
            $table->unsignedBigInteger('tingkat_risiko_keselamatan_id');
            $table->timestamps();

            // membuat nama index yang lebih pendek untuk setiap kolom
            $table->index('laporan_id', 'idx_prioritas_laporan');
            $table->index('tingkat_kerusakan_id', 'idx_prioritas_kerusakan');
            $table->index('dampak_terhadap_aktivitas_akademik_id', 'idx_prioritas_dampak');
            $table->index('frekuensi_penggunaan_fasilitas_id', 'idx_prioritas_frekuensi');
            $table->index('ketersediaan_barang_pengganti_id', 'idx_prioritas_ketersediaan');
            $table->index('tingkat_risiko_keselamatan_id', 'idx_prioritas_risiko');

            // relasi foreign key dengan nama yang lebih pendek
            $table->foreign('laporan_id', 'fk_prioritas_kerusakan_laporan')->references('laporan_id')->on('t_laporan');
            $table->foreign('tingkat_kerusakan_id', 'fk_prioritas_kerusakan_tingkat_kerusakan')->references('tingkat_kerusakan_id')->on('m_tingkat_kerusakan');
            $table->foreign('dampak_terhadap_aktivitas_akademik_id', 'fk_prioritas_kerusakan_dampak')->references('dampak_terhadap_aktivitas_akademik_id')->on('m_dampak_terhadap_aktivitas_akademik');
            $table->foreign('frekuensi_penggunaan_fasilitas_id', 'fk_prioritas_kerusakan_frekuensi')->references('frekuensi_penggunaan_fasilitas_id')->on('m_frekuensi_penggunaan_fasilitas');
            $table->foreign('ketersediaan_barang_pengganti_id', 'fk_prioritas_kerusakan_ketersediaan')->references('ketersediaan_barang_pengganti_id')->on('m_ketersediaan_barang_pengganti');
            $table->foreign('tingkat_risiko_keselamatan_id', 'fk_prioritas_kerusakan_risiko')->references('tingkat_risiko_keselamatan_id')->on('m_tingkat_risiko_keselamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_prioritas_kerusakan');
    }
};
