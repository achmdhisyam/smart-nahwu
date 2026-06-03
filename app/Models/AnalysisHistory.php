<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisHistory extends Model
{
    protected $fillable = [
        'user_id',
        'text_hash',
        'input_text',
        'analysis_result',
    ];

    /**
     * Casts definition using Laravel 12 style array.
     */
    protected function casts(): array
    {
        return [
            'analysis_result' => 'array',
        ];
    }

    /**
     * Relationship: User (creator)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
