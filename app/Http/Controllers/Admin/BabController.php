<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BabJurumiyah;
use Illuminate\Http\Request;

class BabController extends Controller
{
    public function index()
    {
        $chapters = BabJurumiyah::orderBy('nomor_urut')->paginate(10);
        return view('admin.bab.index', compact('chapters'));
    }

    public function create()
    {
        $chapters = BabJurumiyah::whereNull('induk_id')->get();
        return view('admin.bab.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'definisi' => 'required|string',
            'induk_id' => 'nullable|exists:bab_jurumiyah,id',
            'nomor_urut' => 'required|integer',
            'langkah_belajar' => 'required|integer',
        ]);

        BabJurumiyah::create($request->all());

        return redirect()->route('admin.bab.index')->with('success', 'Bab berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $chapter = BabJurumiyah::findOrFail($id);
        $chapters = BabJurumiyah::whereNull('induk_id')->where('id', '!=', $id)->get();
        return view('admin.bab.edit', compact('chapter', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $chapter = BabJurumiyah::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'definisi' => 'required|string',
            'induk_id' => 'nullable|exists:bab_jurumiyah,id',
            'nomor_urut' => 'required|integer',
            'langkah_belajar' => 'required|integer',
        ]);

        $chapter->update($request->all());

        return redirect()->route('admin.bab.index')->with('success', 'Bab berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $chapter = BabJurumiyah::findOrFail($id);
        $chapter->delete();

        return redirect()->route('admin.bab.index')->with('success', 'Bab berhasil dihapus.');
    }
}
