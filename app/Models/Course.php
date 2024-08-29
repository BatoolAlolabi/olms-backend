<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'is_available',
        'is_subscribed',
        'registered_section',
        'student_project'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }

    public function teacher(){
        return $this->belongsTo(User::class,'user_teacher_id');
    }

    public function registerations(){
        return $this->belongsToMany(Registeration::class,'course_registerations');
    }

    public function getIsAvailableAttribute(){
        $courses = Course::query()->whereHas('registerations',function($query){
            $query->where('registerations.started_at','<' , now()->toDateTimeString())
            ->where('registerations.end_at' ,'>', now()->toDateTimeString());
        })->where('id',$this->id)->get();
        return count($courses) > 0 ? true :false;
    }

    public function getIsSubscribedAttribute(){
        $exists = StudentCourseRegistration::query()->where('student_id',auth('api')->id())
        ->where('course_id',$this->id)->exists();
        return $exists ? true : false;
    }
    public function getRegisteredSectionAttribute(){
        return Section::with('sessions')->where('course_id',$this->id)
        ->whereHas('students',function($query){
            $query->where('users.id',auth('api')->id());
        })->first();

    }

    public function getStudentProjectAttribute(){

        $project = CourseProjects::query()->where('course_id',$this->id)->first();
        if(is_object($project)){
            return StudentProjects::query()->where('project_id',$project->id)->where('student_id',auth('api')->id())
            ->first();
        }
        return null;

    }

    public function students(){
        return $this->belongsToMany(User::class,'student_course_registrations','course_id','student_id');
    }

    public function project(){
        return $this->hasOne(CourseProjects::class);
    }
}
