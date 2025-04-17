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
    return view('auth.login');
})->middleware('auth.isLoggedIn');

Route::middleware('auth')->group(function () {
    Route::get('/developers', function () {
        return view('developer');
    })->name('developers');

    Route::get('/skills', function () {
        return view('skills');
    })->name('skills');

    Route::get('/change-password', function () {
        return view('auth.change-password');
    })->name('change-password');
});

require __DIR__.'/auth.php';
