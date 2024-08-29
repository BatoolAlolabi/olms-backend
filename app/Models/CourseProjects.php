<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProjects extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $guarded = [];
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function student_projects(){
        return $this->hasMany(StudentProjects::class,'project_id');
    }

}
