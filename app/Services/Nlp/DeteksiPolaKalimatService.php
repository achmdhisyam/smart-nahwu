<?php

namespace App\Services\Nlp;

use Illuminate\Support\Str;

class DeteksiPolaKalimatService
{
    protected $normalizer;

    public static $commonVerbs = [
        'ضرب', 'قام', 'ذهب', 'جاء', 'جلس', 'أكل', 'مر', 'تصبب', 'انطلق', 'استخرج', 
        'خلق', 'ولد', 'كتب', 'سافر', 'ظn', 'حسب', 'خal', 'زعم', 'رأى', 'علم', 
        'وجد', 'اتخذ', 'جعل', 'سمع', 'كان', 'صار', 'أصبح', 'أمسى', 'أضحى', 'ظل', 
        'بات', 'زال', 'فتئ', 'انفك', 'beruh', 'dam', 'ليس', 'قال', 'أراد', 'شاء',
        'يقom', 'يضرب', 'يذهب', 'يجيء', 'يجلس', 'يأكل', 'يمر', 'يكتب', 'يظن', 'يجعل',
        'يرى', 'يكون', 'tewon', 'أكون', 'nkon', 'يقول', 'يقولon', 'قل'
    ];

    public function __construct(NormalisasiArabService $normalizer)
    {
        $this->normalizer = $normalizer;
        self::$commonVerbs[14] = 'ظن';
        self::$commonVerbs[16] = 'خal';
        self::$commonVerbs[34] = 'برح';
        self::$commonVerbs[35] = 'دام';
        self::$commonVerbs[40] = 'يقوم';
        self::$commonVerbs[44] = 'تكون';
        self::$commonVerbs[46] = 'نكون';
        self::$commonVerbs[48] = 'يقولون';
    }

    /**
     * Mendeteksi pola kalimat (Jumlah Ismiyah atau Jumlah Fi'liyah) berdasarkan array token.
     *
     * @param array $tokens
     * @return string
     */
    public function detect(array $tokens): string
    {
        if (empty($tokens)) {
            return 'Tidak Diketahui';
        }

        // Cari token non-particle pertama
        $firstWord = null;
        foreach ($tokens as $token) {
            if (isset($token['is_particle']) && $token['is_particle'] === true) {
                // Lewati partikel penunjuk seperti Huruf Jar di awal kalimat (misal: "في البيت زيد")
                continue;
            }
            $firstWord = $token['text'];
            break;
        }

        if (!$firstWord) {
            return 'Jumlah Ismiyah'; // Default fallback
        }

        $cleanWord = $firstWord;
        $gundulWord = $this->normalizer->stripDiacritics($cleanWord);

        // Cek jika terdeteksi penanda Fi'il kuat
        if ($this->isVerb($cleanWord, $gundulWord)) {
            return "Jumlah Fi'liyah";
        }

        // Default jika tidak terdeteksi penanda verb kuat adalah Jumlah Ismiyah
        return 'Jumlah Ismiyah';
    }

    /**
     * Memeriksa apakah token adalah Kata Kerja (Fi'il)
     */
    public function isVerb(string $text, string $gundul): bool
    {
        // Penanda Isim absolut: diawali Alif Lam atau diakhiri Ta Marbutah
        if (Str::startsWith($gundul, 'ال') || Str::endsWith($gundul, 'ة')) {
            return false;
        }

        // Diakhiri tanwin
        if (preg_match('/[\x{064B}\x{064C}\x{064D}]$/u', $text)) {
            return false;
        }

        // Cocokkan dengan daftar kata kerja populer
        if (in_array($gundul, self::$commonVerbs)) {
            return true;
        }

        // Diawali penanda fi'il mudhari atau madhi (قد, سوف, س)
        if (Str::startsWith($gundul, ['قد', 'سوف'])) {
            return true;
        }
        if (Str::startsWith($gundul, 'س') && mb_strlen($gundul) > 3) {
            return true;
        }

        // Awalan Mudhara'ah (ي, ت, أ, n) dengan panjang kata standard fi'il mudhari >= 4 huruf
        if (in_array(mb_substr($gundul, 0, 1), ['ي', 'ت', 'أ', 'ن']) && mb_strlen($gundul) >= 4) {
            return true;
        }

        // Akhiran Fi'il Madhi dhomir (seperti كتبْتُ, كتبَتْ, كتبْنَا)
        if (Str::endsWith($gundul, ['ت', 'نا', 'وا', 'تم'])) {
            return true;
        }

        return false;
    }
}
