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

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any}', 'HomeController@index')->where('any', 'home|users.*');

Route::get('/getusers', 'HomeController@getusers')->name('home.getusers');
Route::post('/storeuser', 'HomeController@storeuser')->name('home.storeuser');
Route::put('/updateuser', 'HomeController@updateuser')->name('home.updateuser');
Route::delete('/deleteuser/{id}', 'HomeController@deleteuser')->name('home.deleteuser');

// Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');

Route::get('/role-permission-list', 'AdminController@listRole')->name('role.list');
Route::post('/role-store', 'AdminController@storeRole')->name('role.store');
Route::put('/role-update', 'AdminController@updateRole')->name('role.update');
Route::delete('/deleterole/{id}', 'AdminController@deleteRole')->name('role.delete');

Route::get('/role-list', 'AdminController@getRoleList')->name('role.all');
Route::get('/permission-list', 'AdminController@listPermission')->name('permission.list');
Route::post('/permission-store', 'AdminController@storePermission')->name('permission.store');


Route::get('/home/user/view/{user}', 'AdminController@userView')->name('user.view');
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', function() {
        return 'Admin area';
    });
});
