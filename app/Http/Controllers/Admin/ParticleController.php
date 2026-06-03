<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArabicParticle;
use App\Models\JurumiyahChapter;
use Illuminate\Http\Request;

class ParticleController extends Controller
{
    public function index()
    {
        $particles = ArabicParticle::with('chapter')->paginate(10);
        return view('admin.particles.index', compact('particles'));
    }

    public function create()
    {
        $chapters = JurumiyahChapter::all();
        return view('admin.particles.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:jurumiyah_chapters,id',
            'particle_text' => 'required|string|max:50',
            'particle_type' => 'required|in:jar,nashab,jazm,athaf',
        ]);

        ArabicParticle::create($request->all());

        return redirect()->route('admin.particles.index')->with('success', 'Partikel Arab berhasil ditambahkan.');
    }

    public function destroy(int $id)
    {
        $particle = ArabicParticle::findOrFail($id);
        $particle->delete();

        return redirect()->route('admin.particles.index')->with('success', 'Partikel Arab berhasil dihapus.');
    }
}
