<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalisisTeksRequest;
use App\Models\RiwayatAnalisis;
use App\Models\KaidahGramatika;
use App\Models\BabJurumiyah;
use App\Services\Nlp\MesinSmartNahwu;
use App\Services\Ai\IntegrasiGeminiService;

class AnalisisController extends Controller
{
    protected $nlpEngine;
    protected $geminiService;

    public function __construct(
        MesinSmartNahwu $nlpEngine,
        IntegrasiGeminiService $geminiService
    ) {
        $this->nlpEngine = $nlpEngine;
        $this->geminiService = $geminiService;
    }

    /**
     * Tampilkan halaman utama input analisis.
     */
    public function index()
    {
        return view('analisis.index');
    }

    /**
     * Proses analisis kalimat Arab menggunakan Rule Engine + Gemini.
     */
    public function process(AnalisisTeksRequest $request)
    {
        $inputText = $request->input('input_text');

        // 1. Eksekusi NLP lokal
        $nlpResult = $this->nlpEngine->analyze($inputText);

        // 2. Ambil seluruh kaidah grammar dari DB sebagai referensi lengkap Kitab Al-Ajurrumiyyah
        $relatedRules = KaidahGramatika::with('bab')->get()->map(function ($rule) {
            return [
                'rule_code' => $rule->kode_kaidah,
                'rule_text' => $rule->teks_kaidah,
                'chapter_title' => $rule->bab->judul ?? 'Umum',
            ];
        })->toArray();

        try {
            // 3. Eksekusi analisis AI Gemini
            $aiAnalysis = $this->geminiService->analyze(
                $inputText,
                $nlpResult,
                $relatedRules,
                auth()->id() // null jika user guest
            );

            // Dapatkan ID riwayat yang baru disimpan untuk ditampilkan di halaman hasil
            $hash = hash('sha256', preg_replace('/\s+/u', ' ', trim($inputText)));
            $history = RiwayatAnalisis::where('text_hash', $hash)->first();

            return redirect()->route('analisis.show', $history->id);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memproses analisis: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan detail hasil analisis berdasarkan riwayat/cache.
     */
    public function show(int $id)
    {
        $history = RiwayatAnalisis::findOrFail($id);

        // Ambil referensi bab Jurumiyah terkait untuk ditampilkan di UI
        $chapterIds = collect($history->hasil_analisis['word_by_word_analysis'] ?? [])
            ->pluck('jurumiyah_reference_code')
            ->filter()
            ->unique()
            ->toArray();

        // Cari materi penjelas bab dari database
        $relatedChapters = BabJurumiyah::with('kaidahGramatika')
            ->whereIn('judul', $chapterIds)
            ->orWhereHas('kaidahGramatika', function ($query) use ($chapterIds) {
                $query->whereIn('kode_kaidah', $chapterIds);
            })
            ->get();

        return view('analisis.result', [
            'history' => $history,
            'analysis' => $history->hasil_analisis,
            'relatedChapters' => $relatedChapters
        ]);
    }
}
