<?php

namespace App\Services\Nlp;

use App\Models\ArabicParticle;

class ParticleDetectorService
{
    protected $normalizer;

    public function __construct(ArabicNormalizerService $normalizer)
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
        $particles = ArabicParticle::with('chapter')->get();

        foreach ($particles as $particle) {
            $cleanDbParticle = $this->normalizer->stripDiacritics($particle->particle_text);
            if ($cleanDbParticle === $cleanInput) {
                return [
                    'is_particle' => true,
                    'particle_type' => $particle->particle_type,
                    'rule_reference' => [
                        'chapter_title' => $particle->chapter->title,
                        'chapter_id' => $particle->chapter_id,
                    ]
                ];
            }
        }

        return null;
    }
}
