<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class UserModel extends Authenticatable
{

    use HasFactory;

    protected $table = 'm_users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'role_id',
        'foto_profile',
        'username',
        'name',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public function teknisi()
    {
        return $this->hasOne(TeknisiModel::class, 'user_id');
    }

    public function hasRole($role)
    {
        return $this->role->kode_role == $role;
    }

    public function sentNotifications()
    {
        return $this->hasMany(NotifikasiModel::class, 'sender_id');
    }

// Relasi ke laporan
    public function laporan()
    {
        return $this->hasMany(LaporanModel::class, 'user_id', 'user_id');
    }

    // Relasi ke feedback (yang dibuat oleh user ini)
    public function feedback()
    {
        return $this->hasMany(FeedbackModel::class, 'user_id', 'user_id');
    }

}
