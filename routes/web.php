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

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('home');
})->middleware('auth', 'verified');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/users/updatefield', 'UserController@updateField')->name('users.updatefield');
Route::get('/users/onepage', 'UserController@onePage')->name('users.onepage');
Route::resource('/users', 'UserController');
