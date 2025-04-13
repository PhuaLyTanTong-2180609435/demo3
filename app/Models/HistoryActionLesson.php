<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryActionLesson extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'HistoryActionLesson';
    protected $primaryKey = 'idHistoryLesson';
    public $incrementing = false;
    protected $fillable = ['idAccount', 'idLesson', 'idActionType', 'timeCreated'];
}
