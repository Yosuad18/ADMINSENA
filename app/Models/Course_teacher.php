<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    protected $table = 'course_teachers';
    protected $fillable = ['name', 'email', 'course_id', 'teacher_id'];
}