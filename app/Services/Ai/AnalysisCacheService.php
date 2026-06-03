<?php

namespace App\Services\Ai;

use App\Models\AnalysisHistory;

class AnalysisCacheService
{
    /**
     * Membuat signature hash SHA-256 dari teks kalimat Arab.
     *
     * @param string $text
     * @return string
     */
    public function makeHash(string $text): string
    {
        // Normalisasi whitespace dasar sebelum hashing agar konsisten
        $cleanText = preg_replace('/\s+/u', ' ', trim($text));
        return hash('sha256', $cleanText);
    }

    /**
     * Mencari hasil analisis di database berdasarkan hash kalimat.
     *
     * @param string $hash
     * @return array|null
     */
    public function get(string $hash): ?array
    {
        $history = AnalysisHistory::where('text_hash', $hash)->first();

        return $history ? $history->analysis_result : null;
    }

    /**
     * Menyimpan hasil analisis baru ke database sebagai cache.
     *
     * @param string $text
     * @param string $hash
     * @param array $result
     * @param int|null $userId
     * @return void
     */
    public function set(string $text, string $hash, array $result, ?int $userId = null): void
    {
        // Hindari duplikasi jika ada proses berbarengan
        AnalysisHistory::updateOrCreate(
            ['text_hash' => $hash],
            [
                'user_id' => $userId,
                'input_text' => $text,
                'analysis_result' => $result,
            ]
        );
    }
}
