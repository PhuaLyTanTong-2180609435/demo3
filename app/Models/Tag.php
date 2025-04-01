<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'Tag';
    protected $primaryKey = 'idTag';
    protected $fillable = ['nameTag', 'numberUses', 'description', 'timeCreated'];
}
