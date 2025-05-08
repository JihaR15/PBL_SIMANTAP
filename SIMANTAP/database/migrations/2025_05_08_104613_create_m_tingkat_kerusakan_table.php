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
    {Schema::create('m_tingkat_kerusakan', function (Blueprint $table) {
        $table->id('tingkat_kerusakan_id');
        $table->string('nama_kerusakan', 100);
        $table->double('nilai');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tingkat_kerusakan');
    }
};
