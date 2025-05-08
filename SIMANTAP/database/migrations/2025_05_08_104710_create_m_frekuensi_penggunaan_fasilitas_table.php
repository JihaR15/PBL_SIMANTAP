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
        Schema::create('m_frekuensi_penggunaan_fasilitas', function (Blueprint $table) {
            $table->id('frekuensi_penggunaan_fasilitas_id');
            $table->string('nama_frekuensi', 100);
            $table->double('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_frekuensi_penggunaan_fasilitas');
    }
};
