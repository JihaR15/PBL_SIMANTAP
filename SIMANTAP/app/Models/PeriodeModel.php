<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 'm_periode';
    protected $primaryKey = 'periode_id';
    protected $fillable = ['nama_periode'];

    public function laporan()
    {
        return $this->hasMany(LaporanModel::class, 'periode_id', 'periode_id');
    }
}
