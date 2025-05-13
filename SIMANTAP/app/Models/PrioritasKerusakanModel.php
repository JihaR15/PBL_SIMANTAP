<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrioritasKerusakanModel extends Model
{
    use HasFactory;

    protected $table = 't_prioritas_kerusakan'; 
    protected $primaryKey = 'prioritas_kerusakan_id'; 
    public $timestamps = true; 
    protected $fillable = [
        'laporan_id',
        'tingkat_kerusakan_id',
        'dampak_terhadap_aktivitas_akademik_id',
        'frekuensi_penggunaan_fasilitas_id',
        'ketersediaan_barang_pengganti_id',
        'tingkat_risiko_keselamatan_id',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }


    public function tingkatKerusakan()
    {
        return $this->belongsTo(TingkatKerusakanModel::class, 'tingkat_kerusakan_id', 'tingkat_kerusakan_id');
    }

    public function dampakTerhadapAktivitasAkademik()
    {
        return $this->belongsTo(DampakTerhadapAktivitasAkademikModel::class, 'dampak_terhadap_aktivitas_akademik_id', 'dampak_terhadap_aktivitas_akademik_id');
    }


    public function frekuensiPenggunaanFasilitas()
    {
        return $this->belongsTo(FrekuensiPenggunaanFasilitasModel::class, 'frekuensi_penggunaan_fasilitas_id', 'frekuensi_penggunaan_fasilitas_id');
    }

    public function ketersediaanBarangPengganti()
    {
        return $this->belongsTo(KetersediaanBarangPenggantiModel::class, 'ketersediaan_barang_pengganti_id', 'ketersediaan_barang_pengganti_id');
    }

    public function tingkatRisikoKeselamatan()
    {
        return $this->belongsTo(TingkatRisikoKeselamatanModel::class, 'tingkat_risiko_keselamatan_id', 'tingkat_risiko_keselamatan_id');
    }
}
