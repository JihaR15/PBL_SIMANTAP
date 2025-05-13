<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatKerusakanModel extends Model
{
    use HasFactory;

    protected $table = 'm_tingkat_kerusakan';
    protected $primaryKey = 'tingkat_kerusakan_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_kerusakan',
        'nilai',
    ];
}
