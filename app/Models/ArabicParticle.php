<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArabicParticle extends Model
{
    protected $fillable = [
        'chapter_id',
        'particle_text',
        'particle_type',
    ];

    /**
     * Relationship: Jurumiyah Chapter
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(JurumiyahChapter::class, 'chapter_id');
    }

    /**
     * Scope: Filter by type (jar, nashab, jazm, athaf)
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('particle_type', $type);
    }
}
