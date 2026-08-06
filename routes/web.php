<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;

Route::resource('students', StudentController::class);
Route::resource('topics', TopicController::class);
Route::get('/', function () {
    return view('welcome');
});
