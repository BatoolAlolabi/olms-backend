<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Courses\CourseController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::post('signup',[AuthController::class,'signup']);
    Route::post('login',[AuthController::class,'login']);
});

//users
Route::prefix('users')->middleware('auth:sanctum')->group(function(){
    Route::get('profile',[UsersController::class,'profile']);
    Route::post('update_profile',[UsersController::class,'update_profile']);
});

// categories
Route::resource('categories',CategoryController::class)->middleware('auth:sanctum');

Route::resource('courses',CourseController::class)->middleware('auth:sanctum');
Route::get('courses/courses_of_category/{id}',[CourseController::class,'get_category_courses']);





