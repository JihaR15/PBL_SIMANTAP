<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('m_barang_lokasi', function (Blueprint $table) {
            $table->dropForeign(['tempat_id']);
            $table->foreign('tempat_id')
                ->references('tempat_id')->on('m_tempat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('m_barang_lokasi', function (Blueprint $table) {
            $table->dropForeign(['tempat_id']);
            $table->foreign('tempat_id')
                ->references('tempat_id')->on('m_tempat');
        });
    }
};
