<?php

use App\Http\Controllers\Administrator\LogController;
use App\Http\Controllers\Administrator\PasswordAdministratorController;
use App\Http\Controllers\Administrator\SetFunctionController;
use App\Http\Controllers\Administrator\SetMenuController;
use App\Http\Controllers\Administrator\SetUserController;
use App\Http\Controllers\Administrator\TabelMenuController;

//Administrator
Route::prefix('administrator')->name('modul_administrator.')->group(function () {

    //set_user
    // Route assigned name "set_user.index"...
    Route::name('set_user.')->group(function () {
        Route::get('set-user', [SetUserController::class, 'index'])->name('index');
        Route::get('set-user/index/index-json', [SetUserController::class, 'indexJson'])->name('index.json');
        Route::get('set-user/create', [SetUserController::class, 'create'])->name('create');
        Route::post('set-user/store', [SetUserController::class, 'store'])->name('store');
        Route::get('set-user/edit/{id}', [SetUserController::class, 'edit'])->name('edit');
        Route::get('set-user/reset', [SetUserController::class, 'Reset'])->name('reset');
        Route::post('set-user/update/{id}', [SetUserController::class, 'update'])->name('update');
        Route::delete('set-user/delete', [SetUserController::class, 'delete'])->name('delete');
        Route::post('set-user/export', [SetUserController::class, 'export'])->name('export');
    });
    //end set_user

    //set_menu
    // Route assigned name "set_menu.index"...
    Route::name('set_menu.')->group(function () {
        Route::get('set-menu', [SetMenuController::class, 'index'])->name('index');
        Route::get('set-menu/index/index-json', [SetMenuController::class, 'indexJson'])->name('index.json');
        Route::get('set-menu/edit/{id}', [SetMenuController::class, 'edit'])->name('edit');
        Route::post('set-menu/update/{id}', [SetMenuController::class, 'update'])->name('update');
    });
    //end set_menu
    
    //set_function
    // Route assigned name "set_function.index"...
    Route::name('set_function.')->group(function () {
        Route::get('set-function', [SetFunctionController::class, 'index'])->name('index');
        Route::post('set-function/menuid/json', [SetFunctionController::class, 'menuIdJson'])->name('menuid.json');
        Route::get('set-function/index/index-json', [SetFunctionController::class, 'indexJson'])->name('index.json');
        Route::post('set-function/store', [SetFunctionController::class, 'store'])->name('store');
        Route::get('set-function/edit/{id}', [SetFunctionController::class, 'edit'])->name('edit');
        Route::post('set-function/update/{id}', [SetFunctionController::class, 'update'])->name('update');
    });
    //end set_function

    //tabel_menu
    // Route assigned name "tabel_menu.index"...
    Route::name('tabel_menu.')->group(function () {
        Route::get('tabel-menu', [TabelMenuController::class, 'index'])->name('index');
        Route::get('tabel-menu/index/index-json', [TabelMenuController::class, 'indexJson'])->name('index.json');
        Route::get('tabel-menu/create', [TabelMenuController::class, 'create'])->name('create');
        Route::post('tabel-menu/store', [TabelMenuController::class, 'store'])->name('store');
        Route::get('tabel-menu/edit/{id}', [TabelMenuController::class, 'edit'])->name('edit');
        Route::post('tabel-menu/update/{id}', [TabelMenuController::class, 'update'])->name('update');
        Route::delete('tabel-menu/delete', [TabelMenuController::class, 'delete'])->name('delete');
    });
    //end tabel_menu

    //password_administrator
    // Route assigned name "password_administrator.index"...
    Route::name('password_administrator.')->group(function () {
        Route::get('password-administrator', [PasswordAdministratorController::class, 'index'])->name('index');
        Route::post('password-administrator/pass/json', [PasswordAdministratorController::class, 'passJson'])->name('passJson');
        Route::post('password-administrator/store', [PasswordAdministratorController::class, 'store'])->name('store');
    });
    //end password_administrator

    //log
    // Route assigned name "log.index"...
    Route::name('log.')->group(function () {
        Route::get('log', [LogController::class, 'index'])->name('index');
        Route::get('log/index-json', [LogController::class, 'indexJson'])->name('index.json');
    });
    //end log
});
