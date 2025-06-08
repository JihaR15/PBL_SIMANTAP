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
        Schema::table('t_laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('verifikator_id')->nullable()->after('status_verif');
            $table->foreign('verifikator_id')->references('user_id')->on('m_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_laporan', function (Blueprint $table) {
            
        });
    }
};
