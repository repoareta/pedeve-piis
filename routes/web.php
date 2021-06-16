<?php

use Illuminate\Support\Facades\Route;

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
    return view('login');
});

// Route::get('/', 'AuthController@login')->name('login');
Route::get('/login', 'AuthController@login')->name('login');
Route::post('login_user', 'AuthController@postlogin')->name('login_user.postlogin');
Route::get('/logout', 'AuthController@logout')->name('logout.index');
Route::get('/error', 'AuthController@error')->name('error');


// ROUTE EXTENDED
Route::group([], __DIR__.'/web/modul_administrator.php');
Route::group([], __DIR__.'/web/modul_customer_management.php');
Route::group([], __DIR__.'/web/modul_kontroler.php');
Route::group([], __DIR__.'/web/modul_sdm_payroll.php');
Route::group([], __DIR__.'/web/modul_treasury.php');
Route::group([], __DIR__.'/web/modul_umum.php');
