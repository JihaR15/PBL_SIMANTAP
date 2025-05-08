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
        Schema::create('m_tempat', function (Blueprint $table) {
            $table->id('tempat_id');
            $table->unsignedBigInteger('unit_id')->index();
            $table->string('nama_tempat', 100);
            $table->timestamps();

            $table->foreign('unit_id')->references('unit_id')->on('m_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tempat');
    }
};
