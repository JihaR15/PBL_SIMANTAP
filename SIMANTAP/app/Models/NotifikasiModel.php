<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiModel extends Model
{
    protected $table = 't_notifikasi';
    protected $primaryKey = 'notifikasi_id';

    protected $fillable = [
        'user_id',
        'laporan_id',
        'sender_id',
        'isi_notifikasi',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    public function sender()
    {
        return $this->belongsTo(UserModel::class, 'sender_id', 'user_id');
    }
}
