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
        Schema::create('t_feedback', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->unsignedBigInteger('laporan_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('rating_id')->index();
            $table->text('komentar');
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan');
            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->foreign('rating_id')->references('rating_id')->on('m_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_feedback');
    }
};
