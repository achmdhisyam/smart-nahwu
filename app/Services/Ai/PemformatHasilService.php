<?php

namespace App\Services\Ai;

use InvalidArgumentException;

class PemformatHasilService
{
    /**
     * Memformat respon mentah teks dari Gemini menjadi array JSON standard.
     *
     * @param string $rawResponse
     * @return array
     * @throws InvalidArgumentException
     */
    public function format(string $rawResponse): array
    {
        // 1. Bersihkan pembungkus markdown ```json ... ``` jika LLM mengabaikan instruksi system
        $cleanJson = preg_replace('/^```(?:json)?\s+/iu', '', trim($rawResponse));
        $cleanJson = preg_replace('/\s+```$/u', '', $cleanJson);

        // 2. Decode ke Array PHP
        $decoded = json_decode($cleanJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Gagal melakukan parse JSON hasil AI: " . json_last_error_msg());
        }

        // 3. Validasi skema kunci wajib
        $this->validateSchema($decoded);

        return $decoded;
    }

    /**
     * Memvalidasi keberadaan struktur skema output yang wajib.
     */
    protected function validateSchema(array $data): void
    {
        if (!isset($data['sentence_structure'])) {
            throw new InvalidArgumentException("JSON hasil AI tidak memiliki key: 'sentence_structure'.");
        }

        if (!isset($data['word_by_word_analysis']) || !is_array($data['word_by_word_analysis'])) {
            throw new InvalidArgumentException("JSON hasil AI tidak memiliki key array: 'word_by_word_analysis'.");
        }

        foreach ($data['word_by_word_analysis'] as $index => $item) {
            $required = ['word', 'part_of_speech', 'morphology', 'irab_status', 'irab_marker', 'syntactic_role', 'explanation'];
            foreach ($required as $key) {
                if (!isset($item[$key])) {
                    throw new InvalidArgumentException("Kunci '{$key}' wajib diisi pada item kata indeks {$index}.");
                }
            }
        }
    }
}
