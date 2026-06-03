<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrammarExample;
use App\Models\JurumiyahChapter;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        $examples = GrammarExample::with('chapter')->paginate(10);
        return view('admin.examples.index', compact('examples'));
    }

    public function create()
    {
        $chapters = JurumiyahChapter::all();
        return view('admin.examples.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:jurumiyah_chapters,id',
            'arabic_text' => 'required|string',
            'translation' => 'required|string',
        ]);

        GrammarExample::create($request->all());

        return redirect()->route('admin.examples.index')->with('success', 'Contoh kalimat berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $example = GrammarExample::findOrFail($id);
        $chapters = JurumiyahChapter::all();
        return view('admin.examples.edit', compact('example', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $example = GrammarExample::findOrFail($id);

        $request->validate([
            'chapter_id' => 'required|exists:jurumiyah_chapters,id',
            'arabic_text' => 'required|string',
            'translation' => 'required|string',
        ]);

        $example->update($request->all());

        return redirect()->route('admin.examples.index')->with('success', 'Contoh kalimat berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $example = GrammarExample::findOrFail($id);
        $example->delete();

        return redirect()->route('admin.examples.index')->with('success', 'Contoh kalimat berhasil dihapus.');
    }
}
