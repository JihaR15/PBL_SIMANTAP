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
        Schema::table('t_notifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->nullable()->after('laporan_id');
            $table->foreign('sender_id')->references('user_id')->on('m_users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_notifikasi', function (Blueprint $table) {
            $table->dropColumn('sender_id');
        });
    }
};
