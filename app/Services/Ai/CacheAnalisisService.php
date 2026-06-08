<?php

namespace App\Services\Ai;

use App\Models\RiwayatAnalisis;

class CacheAnalisisService
{
    /**
     * Membuat signature hash SHA-256 dari teks kalimat Arab yang telah dinormalisasi.
     *
     * @param string $text
     * @return string
     */
    public function makeHash(string $text): string
    {
        $normalizer = new \App\Services\Nlp\NormalisasiArabService();
        $gundul = $normalizer->stripDiacritics($text);
        $cleanText = $normalizer->normalize($gundul);
        
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
        $history = RiwayatAnalisis::where('text_hash', $hash)->first();

        return $history ? $history->hasil_analisis : null;
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
        RiwayatAnalisis::updateOrCreate(
            ['text_hash' => $hash],
            [
                'user_id' => $userId,
                'input_text' => $text,
                'hasil_analisis' => $result,
            ]
        );
    }
}
