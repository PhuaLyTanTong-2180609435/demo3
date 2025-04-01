<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'Lesson';
    protected $primaryKey = 'idLesson';
    protected $fillable = ['idCourse', 'idCopyrightType', 'idStatusType', 'lessonName', 'videoAddress', 'description', 'quantityView', 'quantityComment', 'quantityFavorite', 'quantityShared', 'quantitySaved', 'timeCreated'];
}
