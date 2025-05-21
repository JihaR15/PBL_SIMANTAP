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
        Schema::table('t_prioritas', function (Blueprint $table) {
            $table->decimal('jarak_positif', 8, 4)->nullable()->after('tingkat_risiko_keselamatan');
            $table->decimal('jarak_negatif', 8, 4)->nullable()->after('jarak_positif');
            $table->decimal('nilai_topsis', 8, 4)->nullable()->after('jarak_negatif');
            $table->string('klasifikasi_urgensi')->nullable()->after('nilai_topsis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_prioritas', function (Blueprint $table) {
            $table->dropColumn(['jarak_positif', 'jarak_negatif', 'nilai_topsis', 'klasifikasi_urgensi']);
        });
    }
};
