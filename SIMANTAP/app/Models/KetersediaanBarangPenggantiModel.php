<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetersediaanBarangPenggantiModel extends Model
{
    use HasFactory;

    protected $table = 'm_ketersediaan_barang_pengganti';
    protected $primaryKey = 'ketersediaan_barang_pengganti_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_ketersediaan_barang',
        'nilai',
    ];
}
