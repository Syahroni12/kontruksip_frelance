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
    Route::get('/loginAdmin', [App\Http\Controllers\LoginAdminController::class, 'index'])->middleware('guest');
    Route::get('/dashboardAdmin', [App\Http\Controllers\DashboardAdminController::class, 'index'])->middleware('guest');

