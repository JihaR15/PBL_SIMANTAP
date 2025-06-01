<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    use HasFactory;

    protected $table = 't_feedback';
    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'laporan_id',
        'user_id',
        'rating_id',
        'komentar',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function rating()
    {
        return $this->belongsTo(RatingModel::class, 'rating_id', 'rating_id');
    }
   
}
