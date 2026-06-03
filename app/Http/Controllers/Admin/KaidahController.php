<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KaidahGramatika;
use App\Models\BabJurumiyah;
use Illuminate\Http\Request;

class KaidahController extends Controller
{
    public function index()
    {
        $rules = KaidahGramatika::with('bab')->paginate(10);
        return view('admin.kaidah.index', compact('rules'));
    }

    public function create()
    {
        $chapters = BabJurumiyah::all();
        return view('admin.kaidah.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bab_id' => 'required|exists:bab_jurumiyah,id',
            'kode_kaidah' => 'required|string|max:50|unique:kaidah_gramatika,kode_kaidah',
            'teks_kaidah' => 'required|string',
        ]);

        KaidahGramatika::create($request->all());

        return redirect()->route('admin.kaidah.index')->with('success', 'Kaidah berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $rule = KaidahGramatika::findOrFail($id);
        $chapters = BabJurumiyah::all();
        return view('admin.kaidah.edit', compact('rule', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $rule = KaidahGramatika::findOrFail($id);

        $request->validate([
            'bab_id' => 'required|exists:bab_jurumiyah,id',
            'kode_kaidah' => 'required|string|max:50|unique:kaidah_gramatika,kode_kaidah,' . $id,
            'teks_kaidah' => 'required|string',
        ]);

        $rule->update($request->all());

        return redirect()->route('admin.kaidah.index')->with('success', 'Kaidah berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $rule = KaidahGramatika::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.kaidah.index')->with('success', 'Kaidah berhasil dihapus.');
    }
}
