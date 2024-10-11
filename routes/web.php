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
    Route::get('/register_klien', [App\Http\Controllers\AuthController::class, 'register_klien'])->name('register_klien')->middleware('guest');
    Route::post('/register_customeract', [App\Http\Controllers\AuthController::class, 'daftar_customer'])->name('daftar_customer')->middleware('guest');
    Route::post('/register_klienract', [App\Http\Controllers\AuthController::class, 'daftar_klien'])->name('daftar_klien')->middleware('guest');
    Route::post('/loginact', [App\Http\Controllers\AuthController::class, 'loginact'])->name('loginact')->middleware('guest');
    Route::get('/halaman_login', [App\Http\Controllers\AuthController::class, 'login_page'])->name('login')->middleware('guest');
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile')->middleware('auth');
    Route::post('/profile_customeract', [App\Http\Controllers\AuthController::class, 'profile_customeract'])->name('profile_customeract')->middleware('auth');



Route::get('/home_penyediajasa', [App\Http\Controllers\PenyediaJasaController::class, 'index'])->name('home_penyediajasa')->middleware('auth');
Route::get('/dashboard', [App\Http\Controllers\PenyediaJasaController::class, 'dashboard_penyedia'])->name('dashboard_penyedia')->middleware('auth');
Route::get('/tambah_produk', [App\Http\Controllers\PenyediaJasaController::class, 'tambah_produk'])->name('tambah_produk')->middleware('auth');
Route::get('/edit_produk/{id_produk}', [App\Http\Controllers\PenyediaJasaController::class, 'edit_produk'])->name('edit_produk')->middleware('auth');
Route::put('/update_produk/{id_produk}', [App\Http\Controllers\PenyediaJasaController::class, 'update_produk'])->name('update_produk')->middleware('auth');
Route::post('/tambah_produkact', [App\Http\Controllers\PenyediaJasaController::class, 'tambah_produkact'])->name('tambah_produkact')->middleware('auth');
Route::get('/hapus_produk/{id_produk}', [App\Http\Controllers\PenyediaJasaController::class, 'hapus_produk'])->name('hapus_produk')->middleware('auth');
Route::get('/hapus_sertifikat/{id}', [App\Http\Controllers\PenyediaJasaController::class, 'hapus_sertifikat'])->name('hapus_sertifikat')->middleware('auth');
Route::post('/tambah_sertifikat', [App\Http\Controllers\PenyediaJasaController::class, 'tambah_sertifikat'])->name('tambah_sertifikat')->middleware('auth');


Route::get('/home_customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('home_customer')->middleware('auth');
Route::get('/home_customerkategori/{id}', [App\Http\Controllers\CustomerController::class, 'indexkategori'])->name('home_customerkategori')->middleware('auth');
Route::get('/cus_detailproduk/{id}', [App\Http\Controllers\CustomerController::class, 'cus_detailproduk'])->name('cus_detailproduk')->middleware('auth');
Route::get('/checkout/{id}', [App\Http\Controllers\CustomerController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/checkout-success', [App\Http\Controllers\CustomerController::class, 'checkoutact'])->name('checkoutact')->middleware('auth');
Route::get('/halaman_ratingsemua', [App\Http\Controllers\CustomerController::class, 'halaman_rating_semua'])->name('halaman_rating_semua')->middleware('auth');
Route::post('/rating', [App\Http\Controllers\CustomerController::class, 'ratingact'])->name('ratingact')->middleware('auth');





Route::get('/login_admin', [App\Http\Controllers\LoginAdminController::class, 'index'])->middleware('guest');
Route::get('/dashboard_admin', [App\Http\Controllers\DashboardAdminController::class, 'index'])->name('show_dashboard_admin')->middleware('auth');


Route::get('/daftar_penyedia_jasa', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'getDataPenyediaJasa'])->name('show_penyedia_jasa_admin')->middleware('auth');
Route::get('/daftar_penyedia_jasa_diblokir', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'getDataPenyediaJasaDiblokir'])->name('show_penyedia_jasa_diblokir_admin')->middleware('auth');
Route::get('/daftar_penyedia_jasa_diverifikasi', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'getDataPenyediaJasaBelumVerifikasi'])->name('show_penyedia_jasa_diverifikasi_admin')->middleware('auth');
Route::get('/daftar_penyedia_jasa_aman', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'getDataPenyediaJasaAman'])->name('show_penyedia_jasa_aman_admin')->middleware('auth');
Route::post('/penyediajasa_updateee', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'update_status'])->name('penyediajasa.updatee')->middleware('auth');
Route::delete('/penyediajasa/{id}', [App\Http\Controllers\VerfikasiPenyedaJasaAdminController::class, 'destroy'])->name('penyediajasa.destroy')->middleware('auth');

Route::get('/daftar_customer', [App\Http\Controllers\CustomerAdminController::class, 'getDataCustomer'])->name('show_customer_admin')->middleware('auth');
Route::get('/daftar_customer_diblokir', [App\Http\Controllers\CustomerAdminController::class, 'getDataCustomerDiblokir'])->name('show_customer_diblokir_admin')->middleware('auth');
Route::post('/customer_updateee', [App\Http\Controllers\CustomerAdminController::class, 'update_status'])->name('customer.updatee')->middleware('auth');
Route::delete('/customer/{id}', [App\Http\Controllers\CustomerAdminController::class, 'destroy'])->name('customer.destroy')->middleware('auth');

Route::get('/transaksi', [App\Http\Controllers\DashboardAdminController::class, 'index'])->name('show_transaksi_admin')->middleware('auth');

Route::post('loginn_admin', [App\Http\Controllers\AuthController::class, 'loginAdmin'])->name('loginn_admin');
Route::get('auth/google', [App\Http\Controllers\LoginAdminController::class, 'redirectToGoogle']);
Route::get('auth/callback/google', [App\Http\Controllers\LoginAdminController::class, 'handleGoogleCallback']);
