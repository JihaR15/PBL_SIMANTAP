<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknisiModel extends Model
{
    use HasFactory;

    protected $table = 'm_teknisi';
    protected $primaryKey = 'teknisi_id';

    protected $fillable = [
        'user_id',
        'jenis_teknisi_id',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function jenis_teknisi()
    {
        return $this->belongsTo(JenisTeknisiModel::class, 'jenis_teknisi_id');
    }

    // public function perbaikan()
    // {
    //     return $this->hasMany(PerbaikanModel::class, 'teknisi_id');
    // }
}
