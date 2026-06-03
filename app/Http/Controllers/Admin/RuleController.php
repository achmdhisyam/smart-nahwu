<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrammarRule;
use App\Models\JurumiyahChapter;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        $rules = GrammarRule::with('chapter')->paginate(10);
        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $chapters = JurumiyahChapter::all();
        return view('admin.rules.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:jurumiyah_chapters,id',
            'rule_code' => 'required|string|max:50|unique:grammar_rules,rule_code',
            'rule_text' => 'required|string',
        ]);

        GrammarRule::create($request->all());

        return redirect()->route('admin.rules.index')->with('success', 'Kaidah berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $rule = GrammarRule::findOrFail($id);
        $chapters = JurumiyahChapter::all();
        return view('admin.rules.edit', compact('rule', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $rule = GrammarRule::findOrFail($id);

        $request->validate([
            'chapter_id' => 'required|exists:jurumiyah_chapters,id',
            'rule_code' => 'required|string|max:50|unique:grammar_rules,rule_code,' . $id,
            'rule_text' => 'required|string',
        ]);

        $rule->update($request->all());

        return redirect()->route('admin.rules.index')->with('success', 'Kaidah berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $rule = GrammarRule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.rules.index')->with('success', 'Kaidah berhasil dihapus.');
    }
}
