<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'Role';
    protected $primaryKey = 'idRole';
    public $timestamps = false;

    protected $fillable = ['roleName', 'description', 'timeCreated'];

    public function roleDetails()
    {
        return $this->hasMany(RoleDetails::class, 'idRole');
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'RoleDetails', 'idRole', 'idAccount');
    }
}
