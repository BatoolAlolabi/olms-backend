<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProjects extends Model
{
    use HasFactory;

    protected $table = 'student_project';
    protected $guarded = [];

    protected $appends  = [
        'grade'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student(){
        return $this->belongsTo(User::class,'student_id');
    }

    public function getGradeAttribute(){
        return Grades::where('project_id',$this->project_id)->where('student_id',$this->student_id)->first();
    }
}
