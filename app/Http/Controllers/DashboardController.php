<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatAnalisis;
use App\Models\RiwayatKuis;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Statistik Belajar
        $totalAnalisis = RiwayatAnalisis::where('user_id', $userId)->count();
        $totalKuis = RiwayatKuis::where('user_id', $userId)->count();
        $rataKuis = RiwayatKuis::where('user_id', $userId)->avg('skor') ?? 0;

        // Aktivitas Terakhir Analisis
        $recentAnalisis = RiwayatAnalisis::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // Riwayat Kuis Terakhir
        $recentKuis = RiwayatKuis::where('user_id', $userId)
            ->with('kuis.bab')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard.index', compact(
            'totalAnalisis',
            'totalKuis',
            'rataKuis',
            'recentAnalisis',
            'recentKuis'
        ));
    }
}
