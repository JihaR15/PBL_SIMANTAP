<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrioritasModel extends Model
{
    use HasFactory;

    protected $table = 't_prioritas';
    protected $primaryKey = 'prioritas_id';

    protected $fillable = [
        'laporan_id',
        'tingkat_kerusakan',
        'dampak_terhadap_aktivitas_akademik',
        'frekuensi_penggunaan_fasilitas',
        'ketersediaan_barang_pengganti',
        'tingkat_risiko_keselamatan',
        'jarak_positif',
        'jarak_negatif',
        'nilai_topsis',
        'klasifikasi_urgensi',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }
}
