<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('analyze.index');
});

// Grup Rute Guest (Belum Login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Grup Rute Analisis Nahwu
Route::get('/analyze', [AnalysisController::class, 'index'])->name('analyze.index');
Route::post('/analyze', [AnalysisController::class, 'process'])->name('analyze.process');
Route::get('/analyze/history/{id}', [AnalysisController::class, 'show'])->name('analyze.show');

// Grup Rute Riwayat Analisis & Kuis (Harus Login)
Route::middleware(['auth'])->group(function () {
    // Riwayat
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

    // Kuis
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/chapter/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/submit/{id}', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/result/{id}', [QuizController::class, 'result'])->name('quiz.result');
});

// Grup Rute Admin (Harus Login & Role Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'users'])->name('users.index');
    Route::get('/analyses', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'analyses'])->name('analyses.index');
    Route::get('/quizzes', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'quizzes'])->name('quizzes.index');

    Route::resource('chapters', \App\Http\Controllers\Admin\ChapterController::class);
    Route::resource('rules', \App\Http\Controllers\Admin\RuleController::class)->except(['show']);
    Route::resource('examples', \App\Http\Controllers\Admin\ExampleController::class)->except(['show']);
    Route::resource('particles', \App\Http\Controllers\Admin\ParticleController::class)->except(['show', 'edit', 'update']);
});
