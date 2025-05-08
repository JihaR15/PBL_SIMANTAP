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
        Schema::create('m_dampak_terhadap_aktivitas_akademik', function (Blueprint $table) {
            $table->id('dampak_terhadap_aktivitas_akademik_id');
            $table->string('nama_dampak', 100);
            $table->double('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_dampak_terhadap_aktivitas_akademik');
    }
};
