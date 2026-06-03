<?php

namespace App\Http\Controllers;

use App\Models\JurumiyahChapter;
use App\Models\GeneratedQuiz;
use App\Models\QuizHistory;
use App\Services\Quiz\QuizGeneratorService;
use App\Services\Quiz\QuizResultService;
use App\Services\Quiz\QuizService;
use App\Services\Learning\LearningPathService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $quizService;
    protected $generator;
    protected $resultService;
    protected $learningPath;

    public function __construct(
        QuizService $quizService,
        QuizGeneratorService $generator,
        QuizResultService $resultService,
        LearningPathService $learningPath
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

        // 4. Ambil lencana pencapaian (achievements) yang diraih
        $achievements = $user->achievements()->get();

        // 5. Ambil log riwayat kuis terbaru
        $attempts = $this->quizService->getUserQuizHistory($userId, 5);

        return view('quiz.index', compact(
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
        $chapter = JurumiyahChapter::findOrFail($chapterId);
        
        // Buat kuis jika belum ada di database menggunakan AI
        $quiz = $this->generator->generate($chapter);

        return view('quiz.show', compact('chapter', 'quiz'));
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

        $quiz = GeneratedQuiz::findOrFail($quizId);
        $answers = $request->input('answers', []);

        // Hitung nilai dan simpan ke database
        $attempt = $this->resultService->gradeAndSave($quiz, $answers, $userId);

        return redirect()->route('quiz.result', $attempt->id);
    }

    /**
     * Menampilkan lembar hasil pengerjaan kuis beserta pembahasan lengkap.
     */
    public function result(int $attemptId)
    {
        $userId = auth()->id();
        $attempt = QuizHistory::with('quiz.chapter')
            ->where('id', $attemptId)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('quiz.result', compact('attempt'));
    }
}
