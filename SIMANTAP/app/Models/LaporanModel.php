<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanModel extends Model
{
    use HasFactory;

    protected $table = 't_laporan';
    protected $primaryKey = 'laporan_id';

    protected $fillable = [
        'user_id',
        'fasilitas_id',
        'unit_id',
        'tempat_id',
        'barang_lokasi_id',
        'jumlah_barang_rusak',
        'periode_id',
        'kategori_kerusakan_id',
        'status_verif',
        'deskripsi',
        'foto_laporan',
        'verifikator_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function fasilitas()
    {
        return $this->belongsTo(FasilitasModel::class, 'fasilitas_id', 'fasilitas_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitModel::class, 'unit_id', 'unit_id');
    }

    public function tempat()
    {
        return $this->belongsTo(TempatModel::class, 'tempat_id', 'tempat_id');
    }

    public function barangLokasi()
    {
        return $this->belongsTo(BarangLokasiModel::class, 'barang_lokasi_id', 'barang_lokasi_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

    public function kategoriKerusakan()
    {
        return $this->belongsTo(KategoriKerusakanModel::class, 'kategori_kerusakan_id', 'kategori_kerusakan_id');
    }

    // public function prioritas()
    // {
    //     return $this->hasOne(PrioritasKerusakanModel::class, 'laporan_id', 'laporan_id');
    // }

    public function prioritas()
    {
        return $this->hasOne(PrioritasModel::class, 'laporan_id', 'laporan_id');
    }

    // public function topsisHasil()
    // {
    //     return $this->hasOne(TopsisHasilModel::class, 'laporan_id', 'laporan_id');
    // }

    public function perbaikan()
    {
        return $this->hasOne(PerbaikanModel::class, 'laporan_id', 'laporan_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(NotifikasiModel::class, 'laporan_id');
    }

    public function feedback()
    {
        return $this->hasMany(FeedbackModel::class, 'laporan_id', 'laporan_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(UserModel::class, 'verifikator_id', 'user_id');
    }

}
