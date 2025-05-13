<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
     use HasFactory;

    protected $table = 'm_unit';
    protected $primaryKey = 'unit_id';
    public $timestamps = true;

    protected $fillable = [
        'fasilitas_id',
        'nama_unit',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(FasilitasModel::class, 'fasilitas_id', 'fasilitas_id');
    }
}
