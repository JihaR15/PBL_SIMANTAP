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
        Schema::create('m_teknisi', function (Blueprint $table) {
            $table->id('teknisi_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('jenis_teknisi_id')->index();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->foreign('jenis_teknisi_id')->references('jenis_teknisi_id')->on('m_jenis_teknisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_teknisi');
    }
};
