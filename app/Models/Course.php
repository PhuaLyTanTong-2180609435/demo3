<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'Course';
    protected $primaryKey = 'idCourse';
    public $timestamps = false;
    protected $fillable = ['idAccount', 'idIndustryType', 'idPriorityType', 'idCopyrightType', 'idStatusType', 'courseName', 'description', 'quantityFollow', 'quantityView', 'quantityComment', 'quantityFavorite', 'quantityShared', 'quantitySaved', 'timeCreated'];
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'idCourse', 'idCourse');
    }
}
