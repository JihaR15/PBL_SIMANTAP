<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotModel extends Model
{
    protected $table = 'm_bobot';
    protected $primaryKey = 'bobot_id';

    protected $fillable = [
        'nama_parameter',
        'bobot',
    ];
}