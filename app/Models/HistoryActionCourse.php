<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryActionCourse extends Model
{
    use HasFactory;
    protected $table = 'HistoryActionCourse';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idAccount', 'idCourse', 'idActionType', 'timeCreated'];
}
