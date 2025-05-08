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
        Schema::create('m_unit', function (Blueprint $table) {
            $table->id('unit_id');
            $table->unsignedBigInteger('fasilitas_id')->index();
            $table->string('nama_unit', 100);
            $table->timestamps();

            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_unit');
    }
};
