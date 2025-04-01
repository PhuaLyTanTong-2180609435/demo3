<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public $timestamps = false;
    protected $table = 'Account';
    protected $primaryKey = 'idAccount';

    protected $fillable = [
        'accountName',
        'password',
        'name',
        'birthday',
        'description',
        'timeCreated',
        'email',
    ];

    protected $hidden = ['password'];

    // Liên kết với bảng RoleDetails (bảng trung gian)
    public function roleDetails()
    {
        return $this->hasMany(RoleDetails::class, 'idAccount');
    }

    // Lấy vai trò của tài khoản
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'RoleDetails', 'idAccount', 'idRole');
    }
}
