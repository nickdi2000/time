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
use App\Http\Controllers\PageController;

Route::post('/form/apply', [PageController::class, 'apply']);

Route::get('/{any}', [PageController::class, 'index']);
Route::get('/', [PageController::class, 'landing']);

/*
Route::any('{all}', function () {
    return view('app');
})->where(['all' => '.*']);
*/
