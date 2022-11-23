<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PostinganController;
use App\Http\Controllers\PengaturanController;

// route harus menggunakan name agar jika url nya diubah maka kode nya tidak akan error karena aku menggunakan name

// awal beranda
Route::get('/', function() {
	return redirect()->route('beranda.index');
});
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');
Route::get('/beranda/{slug}', [BerandaController::class, 'detail'])->name('beranda.detail');
// akhir beranda

// jika user sudah login maka cegah user mengakses route login dan registrasi kecuali user logout manual
Route::middleware(['auth'])->group(function() {
	// logout
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// rute-rute berikut, hanya bisa diakses oleh admin yang sudah login
Route::middleware(['auth', 'admin'])->group(function() {
	// dashboard hanya bisa diakses oleh admin yang sudah login
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	
	// kategori
	Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
	Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
	Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
	Route::get('/kategori/show', [KategoriController::class, 'show'])->name('kategori.show');
	Route::put('/kategori/update', [KategoriController::class, 'update'])->name('kategori.update');
	Route::delete('/kategori/destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');

	// posting
	Route::get('/postingan', [PostinganController::class, 'index'])->name('postingan.index');
	Route::get('/postingan/data', [PostinganController::class, 'data'])->name('postingan.data');
	Route::get('/postingan/create', [PostinganController::class, 'create'])->name('postingan.create');
	Route::post('/postingan', [PostinganController::class, 'store'])->name('postingan.store');
	Route::get('/postingan/show', [PostinganController::class, 'show'])->name('postingan.show');
	Route::post('/postingan/update', [PostinganController::class, 'update'])->name('postingan.update');
	Route::delete('/postingan/destroy', [PostinganController::class, 'destroy'])->name('postingan.destroy');

	// jadikan admin
	Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
	Route::get('/pengaturan/data', [PengaturanController::class, 'data'])->name('pengaturan.data');
	Route::post('/pengaturan/jadikan-admin', [PengaturanController::class, 'jadikan_admin'])->name('pengaturan.jadikan_admin');
	Route::post('/pengaturan/jadikan-user', [PengaturanController::class, 'jadikan_user'])->name('pengaturan.jadikan_user');
});

// jika user belum login maka cegah ke halaman dashboard 
// jika user belum login maka cegah ke route berikut
Route::middleware(['guest'])->group(function() {
	// Lupa password
	Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
	Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
	Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
	Route::put('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

	// login
	Route::get('/halaman-login', [AuthController::class, 'tampilan_login'])->name('tampilan_login');
	Route::post('/logika-login', [AuthController::class, 'logika_login'])->name('logika_login');

	// registrasi
	Route::get('/halaman-registrasi', [AuthController::class, 'tampilan_registrasi'])->name('halaman_registrasi');
	Route::post('/logika-registrasi', [AuthController::class, 'logika_registrasi'])->name('logika_registrasi');
});

