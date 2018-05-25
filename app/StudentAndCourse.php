<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAndCourse extends Model
{
    protected $fillable = ["id"];
    protected $table = "student_course";
}
