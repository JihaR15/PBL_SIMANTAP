<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DampakTerhadapAktivitasAkademikModel extends Model
{
    use HasFactory;

    protected $table = 'm_dampak_terhadap_aktivitas_akademik';
    protected $primaryKey = 'dampak_terhadap_aktivitas_akademik_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_dampak',
        'nilai',
    ];
}
