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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any}', 'HomeController@index')->where('any', 'dashboard|users.*');

Route::get('/getusers', 'HomeController@getusers')->name('home.getusers');
Route::post('/storeuser', 'HomeController@storeuser')->name('home.storeuser');
Route::put('/updateuser', 'HomeController@updateuser')->name('home.updateuser');
Route::delete('/deleteuser/{id}', 'HomeController@deleteuser')->name('home.deleteuser');

// Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
