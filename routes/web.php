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


Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->middleware('guest');
Route::get('/register_first', [App\Http\Controllers\AuthController::class, 'register_awal'])->name('register_awal')->middleware('guest');
Route::get('/register_customer', [App\Http\Controllers\AuthController::class, 'register_customer'])->name('register_customer')->middleware('guest');
Route::post('/register_customeract', [App\Http\Controllers\AuthController::class, 'daftar_customer'])->name('daftar_customer')->middleware('guest');
Route::get('/halaman_login', [App\Http\Controllers\AuthController::class, 'login_page'])->name('login_page')->middleware('guest');

Route::get('/login_admin', [App\Http\Controllers\LoginAdminController::class, 'index'])->middleware('guest');
Route::get('/dashboard_admin', [App\Http\Controllers\DashboardAdminController::class, 'index'])->name('show_dashboard_admin');
Route::get('/daftar_penyedia_jasa', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'getDataPenyediaJasa'])->name('show_penyedia_jasa_admin');

Route::post('loginn_admin', [App\Http\Controllers\AuthController::class, 'loginAdmin'])->name('loginn_admin');
Route::post('/penyediajasa_updateee', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'update_status'])->name('penyediajasa.updatee');
Route::delete('/penyediajasa/{id}', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'destroy'])->name('penyediajasa.destroy');


Route::get('auth/google', [App\Http\Controllers\LoginAdminController::class, 'redirectToGoogle']);
Route::get('auth/callback/google', [App\Http\Controllers\LoginAdminController::class, 'handleGoogleCallback']);
