<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTeknisiModel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_teknisi';
    protected $primaryKey = 'jenis_teknisi_id';

    public $timestamps = false;

    protected $fillable = ['nama_jenis_teknisi'];

    public function teknisi()
    {
        return $this->hasMany(TeknisiModel::class, 'jenis_teknisi_id');
    }
}
