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
        Schema::create('m_tingkat_risiko_keselamatan', function (Blueprint $table) {
            $table->id('tingkat_risiko_keselamatan_id');
            $table->string('nama_resiko', 100);
            $table->double('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tingkat_risiko_keselamatan');
    }
};
