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
        Schema::create('m_barang_lokasi', function (Blueprint $table) {
            $table->id('barang_lokasi_id');
            $table->unsignedBigInteger('jenis_barang_id')->index();
            $table->unsignedBigInteger('tempat_id')->index();
            $table->timestamps();

            $table->foreign('jenis_barang_id')->references('jenis_barang_id')->on('m_jenis_barang');
            $table->foreign('tempat_id')->references('tempat_id')->on('m_tempat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang_lokasi');
    }
};
