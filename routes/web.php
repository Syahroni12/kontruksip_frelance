<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


    Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('home_landing')->middleware('guest');
    Route::get('/register_first', [App\Http\Controllers\AuthController::class, 'register_awal'])->name('register_awal')->middleware('guest');
    Route::get('/register_customer', [App\Http\Controllers\AuthController::class, 'register_customer'])->name('register_customer')->middleware('guest');
    Route::post('/register_customeract', [App\Http\Controllers\AuthController::class, 'daftar_customer'])->name('daftar_customer')->middleware('guest');
    Route::get('/halaman_login', [App\Http\Controllers\AuthController::class, 'login_page'])->name('login_page')->middleware('guest');

