<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyzeTextRequest;
use App\Models\AnalysisHistory;
use App\Models\GrammarRule;
use App\Models\JurumiyahChapter;
use App\Services\Nlp\SmartNahwuEngine;
use App\Services\Ai\GeminiIntegrationService;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    protected $nlpEngine;
    protected $geminiService;

    public function __construct(
        SmartNahwuEngine $nlpEngine,
        GeminiIntegrationService $geminiService
    ) {
        $this->nlpEngine = $nlpEngine;
        $this->geminiService = $geminiService;
    }

    /**
     * Tampilkan halaman utama input analisis.
     */
    public function index()
    {
        return view('analyze.index');
    }

    /**
     * Proses analisis kalimat Arab menggunakan Rule Engine + Gemini.
     */
    public function process(AnalyzeTextRequest $request)
    {
        $inputText = $request->input('input_text');

        // 1. Eksekusi NLP lokal
        $nlpResult = $this->nlpEngine->analyze($inputText);

        // 2. Ambil seluruh kaidah grammar dari DB sebagai referensi lengkap Kitab Al-Ajurrumiyyah
        $relatedRules = GrammarRule::with('chapter')->get()->map(function ($rule) {
            return [
                'rule_code' => $rule->rule_code,
                'rule_text' => $rule->rule_text,
                'chapter_title' => $rule->chapter->title ?? 'Umum',
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
            $history = AnalysisHistory::where('text_hash', $hash)->first();

            return redirect()->route('analyze.show', $history->id);

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
        $history = AnalysisHistory::findOrFail($id);

        // Ambil referensi bab Jurumiyah terkait untuk ditampilkan di UI
        $chapterIds = collect($history->analysis_result['word_by_word_analysis'] ?? [])
            ->pluck('jurumiyah_reference_code')
            ->filter()
            ->unique()
            ->toArray();

        // Cari materi penjelas bab dari database
        $relatedChapters = JurumiyahChapter::with('grammarRules')
            ->whereIn('title', $chapterIds)
            ->orWhereHas('grammarRules', function ($query) use ($chapterIds) {
                $query->whereIn('rule_code', $chapterIds);
            })
            ->get();

        return view('analyze.result', [
            'history' => $history,
            'analysis' => $history->analysis_result,
            'relatedChapters' => $relatedChapters
        ]);
    }
}
