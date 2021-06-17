
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Administrator\LogController;
use App\Http\Controllers\Administrator\PasswordAdministratorController;
use App\Http\Controllers\Administrator\SetFunctionController;
use App\Http\Controllers\Administrator\SetMenuController;
use App\Http\Controllers\Administrator\SetUserController;
use App\Http\Controllers\Administrator\TabelMenuController;
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

//Administrator
Route::prefix('administrator')->group(function () {

    //set_user
    // Route assigned name "set_user.index"...
    Route::name('set_user.')->group(function () {
        Route::get('set_user', [SetUserController::class, 'index'])->name('index');
        Route::post('set_user/index/search', [SetUserController::class, 'searchIndex'])->name('search.index');
        Route::get('set_user/create', [SetUserController::class, 'create'])->name('create');
        Route::post('set_user/store', [SetUserController::class, 'store'])->name('store');
        Route::get('set_user/edit/{id}', [SetUserController::class, 'edit'])->name('edit');
        Route::get('set_user/reset', [SetUserController::class, 'Reset'])->name('reset');
        Route::post('set_user/update', [SetUserController::class, 'update'])->name('update');
        Route::delete('set_user/delete', [SetUserController::class, 'delete'])->name('delete');
        Route::post('set_user/export', [SetUserController::class, 'export'])->name('export');
    });
    //end set_user

    //set_menu
    // Route assigned name "set_menu.index"...
    Route::name('set_menu.')->group(function () {
        Route::get('set_menu', [SetMenuController::class, 'index'])->name('index');
        Route::post('set_menu/index/search', [SetMenuController::class, 'searchIndex'])->name('search.index');
        Route::post('set_menu/menuid/json', [SetMenuController::class, 'menuidJson'])->name('menuid.json');
        Route::get('set_menu/create/{no}', [SetMenuController::class, 'create'])->name('create');
        Route::post('set_menu/store', [SetMenuController::class, 'store'])->name('store');
        Route::get('set_menu/edit/{no}', [SetMenuController::class, 'edit'])->name('edit');
        Route::post('set_menu/update', [SetMenuController::class, 'update'])->name('update');
        Route::delete('set_menu/delete', [SetMenuController::class, 'delete'])->name('delete');
    });
    //end set_menu
    
    //set_function
    // Route assigned name "set_function.index"...
    Route::name('set_function.')->group(function () {
        Route::get('set_function', [SetFunctionController::class, 'index'])->name('index');
        Route::post('set_function/index/search', [SetFunctionController::class, 'searchIndex'])->name('search.index');
        Route::post('set_function/menuid/json', [SetFunctionController::class, 'menuidJson'])->name('menuid.json');
        Route::get('set_function/create/{no}', [SetFunctionController::class, 'create'])->name('create');
        Route::post('set_function/store', [SetFunctionController::class, 'store'])->name('store');
        Route::get('set_function/edit/{no}', [SetFunctionController::class, 'edit'])->name('edit');
        Route::post('set_function/update', [SetFunctionController::class, 'update'])->name('update');
        Route::delete('set_function/delete', [SetFunctionController::class, 'delete'])->name('delete');
    });
    //end set_function

    //tabel_menu
    // Route assigned name "tabel_menu.index"...
    Route::name('tabel_menu.')->group(function () {
        Route::get('tabel_menu', [TabelMenuController::class, 'index'])->name('index');
        Route::post('tabel_menu/index/search', [TabelMenuController::class, 'searchIndex'])->name('search.index');
        Route::get('tabel_menu/create', [TabelMenuController::class, 'create'])->name('create');
        Route::post('tabel_menu/store', [TabelMenuController::class, 'store'])->name('store');
        Route::get('tabel_menu/edit/{no}', [TabelMenuController::class, 'edit'])->name('edit');
        Route::post('tabel_menu/update', [TabelMenuController::class, 'update'])->name('update');
        Route::delete('tabel_menu/delete', [TabelMenuController::class, 'delete'])->name('delete');
    });
    //end tabel_menu

    //password_administrator
    // Route assigned name "password_administrator.index"...
    Route::name('password_administrator.')->group(function () {
        Route::get('password_administrator', [PasswordController::class, 'index'])->name('index');
        Route::post('password_administrator/pass/json', [PasswordController::class, 'passJson'])->name('passJson');
        Route::post('password_administrator/store', [PasswordController::class, 'store'])->name('store');
    });
    //end password_administrator

    //log
    // Route assigned name "log.index"...
    Route::name('log.')->group(function () {
        Route::get('log', [LogController::class, 'index'])->name('index');
        Route::post('log/search', [LogController::class, 'Search'])->name('search');
    });
    //end log
});