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
        Schema::create('t_prioritas', function (Blueprint $table) {
            $table->id('prioritas_id');
            $table->unsignedBigInteger('laporan_id');
            $table->integer('tingkat_kerusakan');
            $table->integer('dampak_terhadap_aktivitas_akademik');
            $table->integer('frekuensi_penggunaan_fasilitas');
            $table->integer('ketersediaan_barang_pengganti');
            $table->integer('tingkat_risiko_keselamatan');
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_prioritas');
    }
};
