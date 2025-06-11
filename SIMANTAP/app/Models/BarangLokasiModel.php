<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangLokasiModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang_lokasi';
    protected $primaryKey = 'barang_lokasi_id';

    protected $fillable = [
        'jenis_barang_id',
        'tempat_id',
        'jumlah_barang',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarangModel::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function tempat()
    {
        return $this->belongsTo(TempatModel::class, 'tempat_id', 'tempat_id');
    }
}
