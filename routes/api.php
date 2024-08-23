<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Courses\CourseController;
use App\Http\Controllers\Files\FilesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
});



Route::get('home', [HomeController::class, 'index']);

//users
Route::middleware('auth:sanctum')->group(function () {
    Route::post('upload_file', [FilesController::class, 'upload_file']);
    Route::prefix('users')->group(function () {
        Route::get('profile', [UsersController::class, 'profile']);
        Route::post('update_profile', [UsersController::class, 'update_profile']);
    });

    // categories
    Route::resource('categories', CategoryController::class);

    //courses
    Route::resource('courses', CourseController::class);
    Route::get('courses/courses_of_category/{id}', [CourseController::class, 'get_category_courses']);

    //teacher
    Route::resource('teachers', TeacherController::class);

    //student

    Route::resource('students', StudentController::class);
});

Route::get('users/test', [TestController::class, "index"]);
