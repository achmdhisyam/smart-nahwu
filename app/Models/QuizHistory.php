<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizHistory extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'answers_data',
    ];

    /**
     * Casts definition using Laravel 12 style array.
     */
    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'answers_data' => 'array',
        ];
    }

    /**
     * Relationship: User (student)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Generated Quiz
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(GeneratedQuiz::class, 'quiz_id');
    }
}
