<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

*/


Route::group(['middleware' => ['cors']], function() {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('login/refresh', 'Auth\LoginController@refresh');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('register', 'Auth\RegisterController@register');

		Route::resource('guest-course', 'CourseController');

    Route::resource('menu-item', 'MenuItemController');

		Route::post('menu-item/update/{id}', 'MenuItemController@update');
		Route::post('menu-item/create', 'MenuItemController@store');

		Route::resource('menu', 'MenuController');
		Route::post('menu/create', 'MenuController@createOrUpdate');
		Route::post('menu-by-course/{id}', 'MenuController@menuByCourse');

		Route::resource('player', 'PlayerController');
		Route::post('clear-all-players/{course_id}', 'PlayerController@clearAll');
		Route::get('me-player/{id}', 'PlayerController@me');

		Route::get('course/get-by-code/{code}', 'CourseController@getCourseByCode');
		Route::post('course/update-coords/{id}', 'CourseController@updateCoords');
		Route::get('user/my-course', 'UserController@myCourse');

    Route::post('course/find-closest', 'CourseController@findClosest');

});

Route::resource('course', 'CourseController');

Route::group(['middleware' => ['jwt']], function() {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::resource('user', 'UserController');

    Route::get('player/list/{id}', 'PlayerController@list');

    Route::get('me', 'Auth\LoginController@me');
    Route::put('profile', 'ProfileController@update');
});
