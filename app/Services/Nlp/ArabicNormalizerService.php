<?php

namespace App\Services\Nlp;

class ArabicNormalizerService
{
    /**
     * Menormalisasi teks Arab dengan merapikan spasi ganda, tanda baca, dan standarisasi karakter.
     *
     * @param string $text
     * @return string
     */
    public function normalize(string $text): string
    {
        // 1. Bersihkan spasi ganda dan trim
        $text = preg_replace('/\s+/u', ' ', trim($text));

        // 2. Standarisasi Alif Hamzah (أ, إ, آ -> ا) jika diperlukan untuk pencarian fleksibel,
        // namun untuk tasykil awal kita hanya merapikan unicode karakter Arab umum.
        // Menyamakan tatabahasa ya' dan alif maksurah jika ada kesalahan ketik
        $text = str_replace(['ى', 'ئ'], ['ي', 'ئ'], $text);

        return $text;
    }

    /**
     * Menghapus seluruh harakat (tasykil/diacritics) dari teks Arab.
     *
     * @param string $text
     * @return string
     */
    public function stripDiacritics(string $text): string
    {
        $diacritics = [
            '/' . '[\x{064B}-\x{0652}]' . '/u', // Fathatain, Dammatain, Kasratain, Fatha, Damma, Kasra, Shadda, Sukun
            '/' . '[\x{0670}]' . '/u',         // Alif Khanjariah (Superscript Alif)
        ];

        return preg_replace($diacritics, '', $text);
    }
}
