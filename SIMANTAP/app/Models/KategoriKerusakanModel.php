<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKerusakanModel extends Model
{
    use HasFactory;

    protected $table = 'm_kategori_kerusakan';
    protected $primaryKey = 'kategori_kerusakan_id';

    protected $fillable = [
        'nama_kategori',
    ];
}
