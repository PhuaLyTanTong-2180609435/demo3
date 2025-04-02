<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopyrightType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'CopyrightType';
    protected $primaryKey = 'idCopyrightType';
    protected $fillable = ['nameCopyrightType', 'description', 'timeCreated'];
}
