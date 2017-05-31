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


//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', 'UserController@index')->name('user.index');
Route::get('/user_info', 'UserController@user_info')->name('user.user_info');

Route::get('/message/{id}/{direct}', 'MessageController@index')->name('message.index');

Route::put('/message/store', 'MessageController@store')->name('message.store');
Route::put('/message/notify', 'MessageController@notify')->name('message.notify');



