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
        Schema::create('t_perbaikan', function (Blueprint $table) {
            $table->id('perbaikan_id');
            $table->unsignedBigInteger('laporan_id')->index();
            $table->unsignedBigInteger('teknisi_id')->index();
            $table->enum('status_perbaikan', ['belum', 'sedang diperbaiki', 'selesai'])->default('belum');
            $table->double('biaya', 15, 2)->default(0);
            $table->text('catatan_perbaikan')->nullable();
            $table->string('foto_perbaikan');
            $table->timestamp('ditugaskan_pada');
            $table->timestamp('selesai_pada');
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan');
            $table->foreign('teknisi_id')->references('teknisi_id')->on('m_teknisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_perbaikan');
    }
};
