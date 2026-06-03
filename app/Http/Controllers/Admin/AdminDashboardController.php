<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalysisHistory;
use App\Models\QuizHistory;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard monitoring admin.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalAnalyses = AnalysisHistory::count();
        $totalQuizzes = QuizHistory::count();
        
        // Caching efficiency (Mock ratio atau hit kalkulasi)
        $cacheEfficiency = 74.2; 

        // Log riwayat terbaru untuk ditampilkan di dashboard monitoring
        $recentAnalyses = AnalysisHistory::with('user')->latest()->limit(5)->get();
        $recentQuizzes = QuizHistory::with(['user', 'quiz'])->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAnalyses',
            'totalQuizzes',
            'cacheEfficiency',
            'recentAnalyses',
            'recentQuizzes'
        ));
    }

    /**
     * Monitoring: Daftar seluruh pengguna
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Monitoring: Log seluruh riwayat analisis AI
     */
    public function analyses()
    {
        $analyses = AnalysisHistory::with('user')->latest()->paginate(10);
        return view('admin.analyses', compact('analyses'));
    }

    /**
     * Monitoring: Log pengerjaan kuis siswa
     */
    public function quizzes()
    {
        $quizzes = QuizHistory::with(['user', 'quiz'])->latest()->paginate(10);
        return view('admin.quizzes', compact('quizzes'));
    }
}
