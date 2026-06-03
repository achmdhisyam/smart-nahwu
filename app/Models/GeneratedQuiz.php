<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneratedQuiz extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'chapter_id',
        'title',
        'questions_data',
    ];

    /**
     * Casts definition using Laravel 12 style array.
     */
    protected function casts(): array
    {
        return [
            'questions_data' => 'array',
        ];
    }

    /**
     * Relationship: Jurumiyah Chapter
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(JurumiyahChapter::class, 'chapter_id');
    }

    /**
     * Relationship: Quiz Histories (Attempts)
     */
    public function quizHistories(): HasMany
    {
        return $this->hasMany(QuizHistory::class, 'quiz_id');
    }
}
