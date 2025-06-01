<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    use HasFactory;

    protected $table = 'm_rating';
    protected $primaryKey = 'rating_id';

    protected $fillable = [
        'keterangan',
    ];
    
    public function feedbacks()
    {
        return $this->hasMany(FeedbackModel::class, 'rating_id', 'rating_id');
    }
}
