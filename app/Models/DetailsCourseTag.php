<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsCourseTag extends Model
{
    use HasFactory;
    protected $table = 'DetailsCourseTag';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idTag', 'idCourse', 'description', 'timeCreated'];
}
