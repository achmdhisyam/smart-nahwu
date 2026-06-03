<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContohGramatika;
use App\Models\BabJurumiyah;
use Illuminate\Http\Request;

class ContohController extends Controller
{
    public function index()
    {
        $examples = ContohGramatika::with('bab')->paginate(10);
        return view('admin.contoh.index', compact('examples'));
    }

    public function create()
    {
        $chapters = BabJurumiyah::all();
        return view('admin.contoh.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bab_id' => 'required|exists:bab_jurumiyah,id',
            'teks_arab' => 'required|string',
            'terjemahan' => 'required|string',
        ]);

        ContohGramatika::create($request->all());

        return redirect()->route('admin.contoh.index')->with('success', 'Contoh kalimat berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $example = ContohGramatika::findOrFail($id);
        $chapters = BabJurumiyah::all();
        return view('admin.contoh.edit', compact('example', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $example = ContohGramatika::findOrFail($id);

        $request->validate([
            'bab_id' => 'required|exists:bab_jurumiyah,id',
            'teks_arab' => 'required|string',
            'terjemahan' => 'required|string',
        ]);

        $example->update($request->all());

        return redirect()->route('admin.contoh.index')->with('success', 'Contoh kalimat berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $example = ContohGramatika::findOrFail($id);
        $example->delete();

        return redirect()->route('admin.contoh.index')->with('success', 'Contoh kalimat berhasil dihapus.');
    }
}
