<?php

namespace App\Services\Nlp;

class SmartNahwuEngine
{
    protected $normalizer;
    protected $tokenizer;
    protected $particleDetector;
    protected $patternDetector;

    public function __construct(
        ArabicNormalizerService $normalizer,
        ArabicTokenizerService $tokenizer,
        ParticleDetectorService $particleDetector,
        SentencePatternDetectorService $patternDetector
    ) {
        $this->normalizer = $normalizer;
        $this->tokenizer = $tokenizer;
        $this->particleDetector = $particleDetector;
        $this->patternDetector = $patternDetector;
    }

    /**
     * Menganalisis kalimat Arab dan menghasilkan output JSON standard lokal.
     *
     * @param string $text
     * @return array
     */
    public function analyze(string $text): array
    {
        $normalized = $this->normalizer->normalize($text);
        $rawTokens = $this->tokenizer->tokenize($normalized);

        $tokensResult = [];
        foreach ($rawTokens as $index => $tokenText) {
            $particleInfo = $this->particleDetector->detect($tokenText);

            $tokenData = [
                'index' => $index,
                'text' => $tokenText,
                'is_particle' => false,
                'particle_type' => null,
                'rule_reference' => null,
            ];

            if ($particleInfo) {
                $tokenData['is_particle'] = true;
                $tokenData['particle_type'] = $particleInfo['particle_type'];
                $tokenData['rule_reference'] = $particleInfo['rule_reference'];
            }

            $tokensResult[] = $tokenData;
        }

        // Tentukan pola susunan kalimat (Jumlah Ismiyah / Fi'liyah)
        $sentenceType = $this->patternDetector->detect($tokensResult);

        return [
            'raw_text' => $text,
            'normalized_text' => $normalized,
            'sentence_type' => $sentenceType,
            'tokens' => $tokensResult,
        ];
    }
}
