<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\CourseProjects\CourseProjectsController;
use App\Http\Controllers\Courses\CourseController;
use App\Http\Controllers\Files\FilesController;
use App\Http\Controllers\Financial\FinancialController;
use App\Http\Controllers\Financial\TransactionController;
use App\Http\Controllers\Grades\GradesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Lessons\LessonController;
use App\Http\Controllers\Permissions\PermissionsController;
use App\Http\Controllers\Registerations\RegisterationController;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\StudentRegisterations\StudentRegistrationController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::post('signup',[AuthController::class,'signup']);
    Route::post('login',[AuthController::class,'login']);
});

Route::post('upload_file',[FilesController::class,'upload_file']);

Route::get('home',[HomeController::class,'index']);

//users
Route::middleware('auth:sanctum')->group(function(){

Route::prefix('users')->group(function(){
    Route::get('profile',[UsersController::class,'profile']);
    Route::post('update_profile',[UsersController::class,'update_profile']);
});
Route::resource('users',UsersController::class);

// categories
Route::resource('categories',CategoryController::class);

//courses
Route::resource('courses',CourseController::class);
Route::get('courses/courses_of_category/{id}',[CourseController::class,'get_category_courses']);

//lesson
Route::get('lessons/lessons_of_course/{id}',[LessonController::class,'get_course_lessons']);
Route::get('lesson/attend_lesson/{id}',[LessonController::class,'attend_lesson']);
Route::resource('lessons',LessonController::class);


//teacher
Route::resource('teachers',TeacherController::class);

//student

Route::resource('students',StudentController::class);

//financial

Route::get('financials', [FinancialController::class,'index']);
Route::post('financials/deposit_amount',[FinancialController::class,'deposit_amount']);
Route::get('transactions',[TransactionController::class,'index']);


Route::resource('registerations',RegisterationController::class);

//sections
Route::get('sections/sections_of_course/{course_id}',[SectionsController::class,'sections_of_course']);
//permissions
Route::get('user_permissions',[PermissionsController::class,'user_permissions']);

//student registeration
Route::post('student_registeration/register',[StudentRegistrationController::class,'register']);
Route::get('student_registeration',[StudentRegistrationController::class,'index']);
Route::post('student_registeration/my_registeration',[StudentRegistrationController::class,'my_registerations']);
Route::get('registerations/course_students/{course_id}',[RegisterationController::class,'students_of_course']);

// projects
Route::resource('projects',CourseProjectsController::class);
Route::get('projects_of_course/{id}',[CourseProjectsController::class,'projects_of_course']);
Route::post('create_student_project',[CourseProjectsController::class,'create_student_project']);

//grades
Route::put('grades/{id}',[GradesController::class,'update']);
});



