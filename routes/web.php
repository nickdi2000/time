<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\CourseController;

Route::get('/courses', [CourseController::class, 'list']);

Route::any('{all}', function () {
    return view('app');
})->where(['all' => '.*']);
