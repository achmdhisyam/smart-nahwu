<?php

namespace App\Services\Nlp;

use App\Models\HurufTugas;

class DeteksiHurufTugasService
{
    protected $normalizer;

    public function __construct(NormalisasiArabService $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * Mendeteksi partikel huruf Arab (Jar, Nashab, Jazm, Athaf) dari token.
     *
     * @param string $token
     * @return array|null
     */
    public function detect(string $token): ?array
    {
        // Normalisasi token input (hilangkan harakat)
        $cleanInput = $this->normalizer->stripDiacritics($token);

        // Ambil semua partikel terdaftar dari database (jumlahnya sangat sedikit sehingga aman)
        $particles = HurufTugas::with('bab')->get();

        foreach ($particles as $particle) {
            $cleanDbParticle = $this->normalizer->stripDiacritics($particle->kata);
            if ($cleanDbParticle === $cleanInput) {
                return [
                    'is_particle' => true,
                    'particle_type' => $particle->jenis_partikel,
                    'rule_reference' => [
                        'chapter_title' => $particle->bab->judul,
                        'chapter_id' => $particle->bab_id,
                    ]
                ];
            }
        }

        return null;
    }
}
