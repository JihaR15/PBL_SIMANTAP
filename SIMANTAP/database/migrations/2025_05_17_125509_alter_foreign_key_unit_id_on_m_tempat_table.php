<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::table('m_tempat', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->foreign('unit_id')
                ->references('unit_id')->on('m_unit')
                ->onDelete('cascade');
        });
    }

    public function down(){
        Schema::table('m_tempat', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->foreign('unit_id')
                ->references('unit_id')->on('m_unit');
        });
    }
};
