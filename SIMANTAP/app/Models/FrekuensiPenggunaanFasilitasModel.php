<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrekuensiPenggunaanFasilitasModel extends Model
{
    use HasFactory;

    protected $table = 'm_frekuensi_penggunaan_fasilitas';
    protected $primaryKey = 'frekuensi_penggunaan_fasilitas_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_frekuensi',
        'nilai',
    ];
}
