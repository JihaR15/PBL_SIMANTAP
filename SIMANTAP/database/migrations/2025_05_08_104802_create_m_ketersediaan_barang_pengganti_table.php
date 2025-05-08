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
        Schema::create('m_ketersediaan_barang_pengganti', function (Blueprint $table) {
            $table->id('ketersediaan_barang_pengganti_id');
            $table->string('nama_ketersediaan_barang', 100);
            $table->double('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_ketersediaan_barang_pengganti');
    }
};
