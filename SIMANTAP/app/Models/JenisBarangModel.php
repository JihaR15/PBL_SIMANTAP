<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_barang';
    protected $primaryKey = 'jenis_barang_id';

    protected $fillable =[
        'nama_barang',
    ];

    public function tempat()
    {
        return $this->belongsToMany(TempatModel::class, 'm_barang_lokasi', 'jenis_barang_id', 'tempat_id');
    }
}
