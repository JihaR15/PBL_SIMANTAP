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
        Schema::create('t_laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('fasilitas_id')->index();
            $table->unsignedBigInteger('unit_id')->index();
            $table->unsignedBigInteger('tempat_id')->index();
            $table->unsignedBigInteger('barang_lokasi_id')->index();
            $table->unsignedBigInteger('periode_id')->index();
            $table->unsignedBigInteger('kategori_kerusakan_id')->index();
            $table->enum('status_verif', ['belum diverifikasi', 'diverifikasi'])->default('belum diverifikasi');
            $table->text('deskripsi');
            $table->string('foto_laporan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas');
            $table->foreign('unit_id')->references('unit_id')->on('m_unit');
            $table->foreign('tempat_id')->references('tempat_id')->on('m_tempat');
            $table->foreign('barang_lokasi_id')->references('barang_lokasi_id')->on('m_barang_lokasi');
            $table->foreign('periode_id')->references('periode_id')->on('m_periode');
            $table->foreign('kategori_kerusakan_id')->references('kategori_kerusakan_id')->on('m_kategori_kerusakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_laporan');
    }
};
