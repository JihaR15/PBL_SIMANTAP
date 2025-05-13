<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanModel extends Model
{
    use HasFactory;

    protected $table = 't_perbaikan';
    protected $primaryKey = 'perbaikan_id';

    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'status_perbaikan',
        'biaya',
        'catatan_perbaikan',
        'foto_perbaikan',
        'ditugaskan_pada',
        'selesai_pada',
    ];

    protected $dates = [
        'ditugaskan_pada',
        'selesai_pada',
        'created_at',
        'updated_at',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(TeknisiModel::class, 'teknisi_id', 'teknisi_id');
    }
}
