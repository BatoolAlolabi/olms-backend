<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProjects extends Model
{
    use HasFactory;
    public function Course(){
        return $this->belongsTo(Course::class);
    }
    public function StudentProjects(){
        return $this->belongsTo(StudentProjects::class);
    }

}
