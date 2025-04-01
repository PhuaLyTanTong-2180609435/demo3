<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsLessonTag extends Model
{
    use HasFactory;
    protected $table = 'DetailsLessonTag';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idTag', 'idLesson', 'description', 'timeCreated'];
}
