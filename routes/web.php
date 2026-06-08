<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LupaPasswordController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\BelajarController;
use Illuminate\Support\Facades\Route;

// Google Authentication Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/google/mock', [GoogleAuthController::class, 'mockPage'])->name('auth.google.mock');
Route::post('/auth/google/mock/callback', [GoogleAuthController::class, 'mockCallback'])->name('auth.google.mock.callback');

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Grup Rute Guest (Belum Login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Lupa Password
    Route::get('/lupa-password', [LupaPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/lupa-password', [LupaPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [LupaPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [LupaPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Grup Rute Analisis Nahwu
Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');
Route::post('/analisis', [AnalisisController::class, 'process'])->name('analisis.process')->middleware('throttle:10,1');
Route::get('/analisis/riwayat/{hash}', [AnalisisController::class, 'show'])->name('analisis.show');

// Modul Belajar (E-Book)
Route::get('/belajar', [BelajarController::class, 'index'])->name('belajar.index');
Route::get('/belajar/bab/{hash}', [BelajarController::class, 'show'])->name('belajar.show');

// Grup Rute Riwayat Analisis & Kuis (Harus Login)
Route::middleware(['auth'])->group(function () {
    // Dashboard Santri
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Modul Belajar
    Route::post('/belajar/bab/{hash}/selesai', [BelajarController::class, 'complete'])->name('belajar.complete');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');

    // Kuis
    Route::get('/kuis', [KuisController::class, 'index'])->name('kuis.index');
    Route::get('/kuis/bab/{id}', [KuisController::class, 'show'])->name('kuis.show');
    Route::post('/kuis/submit/{id}', [KuisController::class, 'submit'])->name('kuis.submit');
    Route::get('/kuis/hasil/{hash}', [KuisController::class, 'result'])->name('kuis.result');

    // Profil & Password
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// Grup Rute Admin (Harus Login & Role Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardAdminController::class, 'index'])->name('dashboard');
    Route::get('/analyses', [\App\Http\Controllers\Admin\DashboardAdminController::class, 'analyses'])->name('analyses.index');
    Route::get('/quizzes', [\App\Http\Controllers\Admin\DashboardAdminController::class, 'quizzes'])->name('quizzes.index');

    Route::resource('pengguna', \App\Http\Controllers\Admin\PenggunaController::class);
    Route::resource('bab', \App\Http\Controllers\Admin\BabController::class);
    Route::resource('kaidah', \App\Http\Controllers\Admin\KaidahController::class)->except(['show']);
    Route::resource('contoh', \App\Http\Controllers\Admin\ContohController::class)->except(['show']);
    Route::resource('huruf-tugas', \App\Http\Controllers\Admin\HurufTugasController::class)->except(['show', 'edit', 'update']);
});
