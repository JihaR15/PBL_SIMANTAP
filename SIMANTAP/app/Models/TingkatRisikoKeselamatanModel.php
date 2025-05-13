<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatRisikoKeselamatanModel extends Model
{
    use HasFactory;

    protected $table = 'm_tingkat_risiko_keselamatan';
    protected $primaryKey = 'tingkat_risiko_keselamatan_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_resiko',
        'nilai',
    ];
}
