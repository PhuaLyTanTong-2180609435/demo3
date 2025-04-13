<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ActionType';
    protected $primaryKey = 'idActionType';
    protected $fillable = ['actionTypeName', 'description', 'timeCreated'];
}
