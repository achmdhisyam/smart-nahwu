<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'chapter_id',
        'status',
        'attempts_count',
        'best_score',
        'last_attempt_at',
    ];

    protected function casts(): array
    {
        return [
            'best_score' => 'decimal:2',
            'last_attempt_at' => 'datetime',
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
     * Relationship: Jurumiyah Chapter
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(JurumiyahChapter::class, 'chapter_id');
    }
}
