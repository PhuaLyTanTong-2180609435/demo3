<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'IndustryType';
    protected $primaryKey = 'idIndustryType';
    protected $fillable = ['nameIndustryType', 'description', 'timeCreated'];
}
