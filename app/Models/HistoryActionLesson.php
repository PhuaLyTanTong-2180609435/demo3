<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryActionLesson extends Model
{
    use HasFactory;
    protected $table = 'HistoryActionLesson';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idAccount', 'idLesson', 'idActionType', 'timeCreated'];
}
