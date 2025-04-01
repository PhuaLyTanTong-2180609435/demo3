<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDetails extends Model
{
    use HasFactory;

    protected $table = 'RoleDetails';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['idAccount', 'idRole', 'timeCreated'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'idAccount');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'idRole');
    }
}
