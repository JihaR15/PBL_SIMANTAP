<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatModel extends Model
{
     use HasFactory;

    protected $table = 'm_tempat'; 
    protected $primaryKey = 'tempat_id'; 
    public $timestamps = true; 

    protected $fillable = [
        'unit_id',
        'nama_tempat',
    ];

    public function unit()
    {
        return $this->belongsTo(UnitModel::class, 'unit_id', 'unit_id');
    }
}
