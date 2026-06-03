<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurumiyahChapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index()
    {
        $chapters = JurumiyahChapter::orderBy('order_num')->paginate(10);
        return view('admin.chapters.index', compact('chapters'));
    }

    public function create()
    {
        $chapters = JurumiyahChapter::whereNull('parent_id')->get();
        return view('admin.chapters.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'definition' => 'required|string',
            'parent_id' => 'nullable|exists:jurumiyah_chapters,id',
            'order_num' => 'required|integer',
        ]);

        JurumiyahChapter::create($request->all());

        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $chapter = JurumiyahChapter::findOrFail($id);
        $chapters = JurumiyahChapter::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.chapters.edit', compact('chapter', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $chapter = JurumiyahChapter::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'definition' => 'required|string',
            'parent_id' => 'nullable|exists:jurumiyah_chapters,id',
            'order_num' => 'required|integer',
        ]);

        $chapter->update($request->all());

        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $chapter = JurumiyahChapter::findOrFail($id);
        $chapter->delete();

        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil dihapus.');
    }
}
