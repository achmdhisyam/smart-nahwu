<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HurufTugas;
use App\Models\BabJurumiyah;
use Illuminate\Http\Request;

class HurufTugasController extends Controller
{
    public function index()
    {
        $particles = HurufTugas::with('bab')->paginate(10);
        return view('admin.huruf_tugas.index', compact('particles'));
    }

    public function create()
    {
        $chapters = BabJurumiyah::all();
        return view('admin.huruf_tugas.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bab_id' => 'required|exists:bab_jurumiyah,id',
            'kata' => 'required|string|max:50',
            'jenis_partikel' => 'required|in:jar,nashab,jazm,athaf',
        ]);

        HurufTugas::create($request->all());

        return redirect()->route('admin.huruf_tugas.index')->with('success', 'Huruf Tugas berhasil ditambahkan.');
    }

    public function destroy(int $id)
    {
        $particle = HurufTugas::findOrFail($id);
        $particle->delete();

        return redirect()->route('admin.huruf_tugas.index')->with('success', 'Huruf Tugas berhasil dihapus.');
    }
}
