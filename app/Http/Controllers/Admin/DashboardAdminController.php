<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAnalisis;
use App\Models\RiwayatKuis;
use App\Models\User;

class DashboardAdminController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard monitoring admin.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalAnalyses = RiwayatAnalisis::count();
        $totalQuizzes = RiwayatKuis::count();
        
        // Caching efficiency (Mock ratio atau hit kalkulasi)
        $cacheEfficiency = 74.2; 

        // Log riwayat terbaru untuk ditampilkan di dashboard monitoring
        $recentAnalyses = RiwayatAnalisis::with('user')->latest()->limit(5)->get();
        $recentQuizzes = RiwayatKuis::with(['user', 'kuis'])->latest()->limit(5)->get();

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
        return view('admin.pengguna', compact('users'));
    }

    /**
     * Monitoring: Log seluruh riwayat analisis AI
     */
    public function analyses()
    {
        $analyses = RiwayatAnalisis::with('user')->latest()->paginate(10);
        return view('admin.analisis', compact('analyses'));
    }

    /**
     * Monitoring: Log pengerjaan kuis siswa
     */
    public function quizzes()
    {
        $quizzes = RiwayatKuis::with(['user', 'kuis'])->latest()->paginate(10);
        return view('admin.kuis', compact('quizzes'));
    }
}
