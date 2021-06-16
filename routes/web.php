<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;

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
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin'])->name('login_user.postlogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.index');
Route::get('/error', [AuthController::class, 'error'])->name('error');

Route::name('default.')->group(function () {
    Route::get('default', [AuthController::class, 'index'])->name('index');
});

// ROUTE EXTENDED
Route::group([], __DIR__.'/web/modul_administrator.php');
Route::group([], __DIR__.'/web/modul_customer_management.php');
Route::group([], __DIR__.'/web/modul_kontroler.php');
Route::group([], __DIR__.'/web/modul_sdm_payroll.php');
Route::group([], __DIR__.'/web/modul_treasury.php');
Route::group([], __DIR__.'/web/modul_umum.php');
