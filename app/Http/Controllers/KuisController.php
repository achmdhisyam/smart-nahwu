<?php

namespace App\Http\Controllers;

use App\Models\BabJurumiyah;
use App\Models\BuatKuis;
use App\Models\RiwayatKuis;
use App\Services\Kuis\PembuatKuisService;
use App\Services\Kuis\HasilKuisService;
use App\Services\Kuis\KuisService;
use App\Services\Pembelajaran\AlurBelajarService;
use Illuminate\Http\Request;
use App\Helpers\HashidsHelper;

class KuisController extends Controller
{
    protected $quizService;
    protected $generator;
    protected $resultService;
    protected $learningPath;

    public function __construct(
        KuisService $quizService,
        PembuatKuisService $generator,
        HasilKuisService $resultService,
        AlurBelajarService $learningPath
    ) {
        $this->quizService = $quizService;
        $this->generator = $generator;
        $this->resultService = $resultService;
        $this->learningPath = $learningPath;
    }

    /**
     * Tampilkan halaman daftar kuis bab Jurumiyah dengan alur progress belajar.
     */
    public function index()
    {
        $userId = auth()->id();
        $user = auth()->user();
        
        if (!$userId || !$user) {
            return redirect()->route('login')->with('info', 'Silakan masuk terlebih dahulu untuk memulai latihan kuis.');
        }

        // 1. Ambil data bab berserta status progress belajar
        $chapters = $this->learningPath->getChaptersWithProgress($userId);

        // 2. Ambil statistik pencapaian & progress belajar
        $stats = $this->learningPath->getProgressStats($userId);

        // 3. Ambil rekomendasi bab belajar berikutnya
        $recommendation = $this->learningPath->getRecommendation($userId);

        // 4. Ambil pencapaian yang diraih
        $achievements = $user->pencapaian()->get();

        // 5. Ambil log riwayat kuis terbaru
        $attempts = $this->quizService->getUserQuizHistory($userId, 5);

        return view('kuis.index', compact(
            'chapters', 
            'attempts', 
            'stats', 
            'recommendation', 
            'achievements'
        ));
    }

    /**
     * Memulai kuis untuk bab Jurumiyah tertentu (auto-generate jika belum ada).
     */
    public function show(int $chapterId)
    {
        $chapter = BabJurumiyah::findOrFail($chapterId);
        
        // Buat kuis jika belum ada di database menggunakan AI
        $quiz = $this->generator->generate($chapter);

        return view('kuis.show', compact('chapter', 'quiz'));
    }

    /**
     * Memproses submit lembar jawaban kuis dan menampilkan hasil skor.
     */
    public function submit(Request $request, int $quizId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $quiz = BuatKuis::findOrFail($quizId);
        $answers = $request->input('answers', []);

        // Hitung nilai dan simpan ke database
        $attempt = $this->resultService->gradeAndSave($quiz, $answers, $userId);

        return redirect()->route('kuis.result', HashidsHelper::encode($attempt->id))->with('quiz_submitted', true);
    }

    /**
     * Menampilkan lembar hasil pengerjaan kuis beserta pembahasan lengkap.
     */
    public function result(string $hash)
    {
        $userId = auth()->id();
        $id = HashidsHelper::decode($hash);
        if (!$id) {
            abort(404);
        }

        $attempt = RiwayatKuis::with('kuis.bab')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('kuis.result', compact('attempt'));
    }
}
