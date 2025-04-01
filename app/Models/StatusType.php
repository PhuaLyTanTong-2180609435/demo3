<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusType extends Model
{
    use HasFactory;
    protected $table = 'StatusType';
    protected $primaryKey = 'idStatusType';
    protected $fillable = ['nameStatusType', 'description', 'timeCreated'];
}
