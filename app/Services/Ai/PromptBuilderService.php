<?php

namespace App\Services\Ai;

class PromptBuilderService
{
    /**
     * Membangun prompt instruksi ketat untuk Gemini.
     *
     * @param string $sentence
     * @param array $nlpResult
     * @param array $relatedRules
     * @return string
     */
    public function buildPrompt(string $sentence, array $nlpResult, array $relatedRules): string
    {
        $payload = [
            'teks_input_arab' => $sentence,
            'analisis_rule_engine_lokal' => [
                'tipe_kalimat' => $nlpResult['sentence_type'] ?? 'Tidak Diketahui',
                'token' => array_map(function ($token) {
                    return [
                        'index' => $token['index'],
                        'kata' => $token['text'],
                        'is_partikel' => $token['is_particle'],
                        'tipe_partikel' => $token['particle_type']
                    ];
                }, $nlpResult['tokens'] ?? [])
            ],
            'konteks_kaidah_jurumiyah_terkait' => array_map(function ($rule) {
                return [
                    'kode' => $rule['rule_code'] ?? 'RULE_UNKNOWN',
                    'nama_bab' => $rule['chapter_title'] ?? 'Umum',
                    'teks_kaidah' => $rule['rule_text'] ?? ''
                ];
            }, $relatedRules)
        ];

        $jsonPayload = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $modeInstruction = "PENTING: Lakukan analisis lengkap mencakup Nahwu (Sintaksis & I'rab) dan Shorof (Morfologi kata) secara mendalam untuk semua kolom.";

        return <<<PROMPT
Anda adalah "Smart Nahwu AI", asisten tata bahasa Arab klasik (Nahwu, Shorof, I'rab) yang sangat patuh pada kaidah Kitab Matan Al-Ajurrumiyyah.

Tugas Anda adalah:
1. Menganalisis kedudukan I'rab dan Shorof kata-per-kata dari kalimat Arab yang diberikan.
2. Memvalidasi dan menyempurnakan hasil analisis awal dari Rule Engine Lokal.
3. Menghubungkan setiap kata dengan kaidah Jurumiyah yang relevan yang disediakan di dalam payload konteks.

{$modeInstruction}

Input Data dalam format JSON:
{$jsonPayload}

Aturan Output:
1. Anda wajib merespon HANYA dalam format JSON yang valid. Jangan sertakan markdown "```json" atau teks pembuka/penutup lainnya.
2. Gunakan Bahasa Indonesia untuk kolom penjelasan (explanation) dan terjemahan. Gunakan tulisan Arab berharakat untuk teks Arab/I'rab.
3. Di dalam kolom penjelasan ("explanation"), ketika merujuk pada kaidah Jurumiyah, JANGAN menampilkan nama kode kaidah seperti "RULE_KALAM_2", "Kaidah Kalam 2", "Rule 1", atau sebutan kode/angka sejenis. Anda wajib menuliskan bunyi kaidah aslinya secara lengkap dan langsung di dalam kalimat penjelasan (contoh: "...sesuai dengan bunyi kaidah bahwa Isim itu diketahui dengan adanya khafadh, tanwin, dan kemasukan alif dan lam..."). Jangan menyingkatnya dengan sebutan kode atau angka bab saja.
4. Struktur output JSON wajib persis mengikuti skema di bawah ini:
{
  "sentence_structure": "Jumlah Fi'liyah" atau "Jumlah Ismiyah",
  "vocalized_sentence": "Teks seluruh kalimat lengkap Bahasa Arab yang sudah diberi harakat/diakritik secara lengkap, benar, dan sempurna",
  "word_by_word_analysis": [
    {
      "word": "Teks kata asli Arab (persis sesuai potongan kata dari input asli tanpa diubah)",
      "vocalized_word": "Potongan kata Arab tersebut yang sudah diberi harakat lengkap secara tepat",
      "part_of_speech": "Isim" atau "Fi'il" atau "Huruf",
      "morphology": "Rincian analisis Shorof lengkap mencakup Shighah (bentuk kata), Wazan (pola pola kata/timbangan), Bina' (tipe konstruksi huruf), dan Asal Kata (Mujarrad/Mazeed). Contoh: 'Shighah: Isim Fa'il | Wazan: فَاعِلٌ | Bina': Shahih Salim | Asal: Tsulatsi Mujarrad'",
      "irab_status": "Rafa'" atau "Nashab" atau "Jar" atau "Jazm" atau "Mabni",
      "irab_marker": "Tanda I'rab (misal: Dhammah, Fathah, Kasrah, Sukun)",
      "syntactic_role": "Kedudukan tata bahasa (misal: Fa'il, Mubtada, Khabar, Majrur)",
      "explanation": "Penjelasan/alasan mengapa kata tersebut ber-I'rab demikian, alasan mengapa menggunakan tanda I'rab tersebut secara spesifik (contoh: karena merupakan Isim Mufrad, Jama' Taksir, dsb.), dan dihubungkan secara langsung dengan bunyi teks kaidah Jurumiyah terkait.",
      "jurumiyah_reference_code": "Masukkan nilai 'nama_bab' (chapter_title) yang COCOK dari konteks kaidah (contoh: 'Mubtada dan Khabar', 'Kalam', 'Fa'il') agar sistem bisa merujuk bab materi dengan tepat di UI."
    }
  ]
}
PROMPT;
    }
}
