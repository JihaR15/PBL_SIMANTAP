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
        Schema::create('t_topsis_hasil', function (Blueprint $table) {
            $table->id('topsis_hasil_id');
            $table->unsignedBigInteger('laporan_id');
            $table->double('jarak_positif');
            $table->double('jarak_negatif');
            $table->double('nilai_topsis');
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_topsis_hasil');
    }
};
