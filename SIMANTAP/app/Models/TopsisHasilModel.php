<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopsisHasilModel extends Model
{
    use HasFactory;

    protected $table = 't_topsis_hasil';
    protected $primaryKey = 'topsis_hasil_id';

    protected $fillable = [
        'laporan_id',
        'jarak_positif',
        'jarak_negatif',
        'nilai_topsis',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }
}
