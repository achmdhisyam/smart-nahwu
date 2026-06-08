<?php

namespace App\Http\Controllers;

use App\Models\BabJurumiyah;
use App\Models\ProgresPengguna;
use App\Helpers\HashidsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BelajarController extends Controller
{
    /**
     * Tampilkan halaman utama modul belajar (daftar bab/peta belajar).
     */
    public function index()
    {
        // Load bab utama beserta sub-babnya
        $chapters = BabJurumiyah::whereNull('induk_id')
            ->with(['anak' => function ($query) {
                $query->orderBy('nomor_urut');
            }])
            ->orderBy('nomor_urut')
            ->get();

        // Load progress pengguna jika sudah login
        $userProgress = [];
        if (Auth::check()) {
            $userProgress = ProgresPengguna::where('user_id', Auth::id())
                ->get()
                ->keyBy('bab_id')
                ->toArray();
        }

        // Generate hash untuk setiap bab
        $chapters->each(function ($chapter) use ($userProgress) {
            $chapter->hash = HashidsHelper::encode($chapter->id);
            $chapter->status_belajar = $userProgress[$chapter->id]['status'] ?? 'belum';
            
            $chapter->anak->each(function ($sub) use ($userProgress) {
                $sub->hash = HashidsHelper::encode($sub->id);
                $sub->status_belajar = $userProgress[$sub->id]['status'] ?? 'belum';
            });
        });

        return view('belajar.index', compact('chapters'));
    }

    /**
     * Tampilkan detail materi bab tertentu.
     */
    public function show($hash)
    {
        $id = HashidsHelper::decode($hash);
        if (!$id) {
            abort(404);
        }

        $chapter = BabJurumiyah::with(['kaidahGramatika', 'contohGramatika', 'hurufTugas', 'buatKuis', 'induk'])
            ->findOrFail($id);

        // Tandai otomatis sebagai sedang dipelajari ('belajar') jika user sudah login
        if (Auth::check()) {
            ProgresPengguna::updateOrCreate(
                ['user_id' => Auth::id(), 'bab_id' => $chapter->id],
                ['status' => 'belajar']
            );
        }

        // Cari bab sebelum dan sesudah untuk navigasi
        // Cari bab secara global terurut berdasarkan nomor_urut
        $allChapters = BabJurumiyah::orderBy('nomor_urut')->get();
        $currentIndex = $allChapters->pluck('id')->search($chapter->id);
        
        $prevChapter = $currentIndex > 0 ? $allChapters[$currentIndex - 1] : null;
        $nextChapter = $currentIndex < $allChapters->count() - 1 ? $allChapters[$currentIndex + 1] : null;

        if ($prevChapter) {
            $prevChapter->hash = HashidsHelper::encode($prevChapter->id);
        }
        if ($nextChapter) {
            $nextChapter->hash = HashidsHelper::encode($nextChapter->id);
        }

        // Cek status progress bab ini
        $progress = null;
        if (Auth::check()) {
            $progress = ProgresPengguna::where('user_id', Auth::id())
                ->where('bab_id', $chapter->id)
                ->first();
        }

        return view('belajar.show', compact('chapter', 'prevChapter', 'nextChapter', 'progress', 'hash'));
    }

    /**
     * Tandai bab ini selesai dipelajari.
     */
    public function complete($hash)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $id = HashidsHelper::decode($hash);
        if (!$id) {
            abort(404);
        }

        ProgresPengguna::updateOrCreate(
            ['user_id' => Auth::id(), 'bab_id' => $id],
            ['status' => 'selesai']
        );

        return redirect()->back()->with('success', 'Selamat! Anda telah menyelesaikan bab ini.');
    }
}
