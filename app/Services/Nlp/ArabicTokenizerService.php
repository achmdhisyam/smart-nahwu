<?php

namespace App\Services\Nlp;

class ArabicTokenizerService
{
    /**
     * Memecah kalimat bahasa Arab menjadi token kata individual.
     *
     * @param string $text
     * @return array<string>
     */
    public function tokenize(string $text): array
    {
        // Bersihkan tanda baca bahasa Arab & umum sebelum melakukan tokenize
        $cleanText = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()؟?«»،؛]/u', ' ', $text);
        
        // Memecah berdasarkan spasi
        $tokens = preg_split('/\s+/u', trim($cleanText));

        return array_filter($tokens, function ($token) {
            return !empty(trim($token));
        });
    }
}
