<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrammarExample extends Model
{
    protected $fillable = [
        'chapter_id',
        'arabic_text',
        'translation',
    ];

    /**
     * Relationship: Jurumiyah Chapter
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(JurumiyahChapter::class, 'chapter_id');
    }
}
