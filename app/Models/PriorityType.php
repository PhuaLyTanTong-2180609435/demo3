<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriorityType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'PriorityType';
    protected $primaryKey = 'idPriorityType';
    protected $fillable = ['namePriorityType', 'description', 'timeCreated'];
}
