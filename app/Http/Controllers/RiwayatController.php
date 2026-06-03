<?php

namespace App\Http\Controllers;

use App\Services\Riwayat\RiwayatService;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    protected $historyService;

    public function __construct(RiwayatService $historyService)
    {
        $this->historyService = $historyService;
    }

    /**
     * Menampilkan daftar riwayat analisis milik user (Halaman Dashboard/Riwayat).
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        
        // Proteksi: Jika user belum login, redirect ke halaman analyze
        if (!$userId) {
            return redirect()->route('analisis.index');
        }

        $search = $request->query('search');
        $histories = $this->historyService->getUserHistory($userId, $search);

        return view('riwayat.index', compact('histories', 'search'));
    }

    /**
     * Menghapus salah satu item riwayat dari database.
     */
    public function destroy(int $id)
    {
        $userId = auth()->id();

        if ($userId) {
            $this->historyService->deleteHistory($id, $userId);
        }

        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil dihapus.');
    }
}
