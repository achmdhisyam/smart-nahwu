<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrammarRule extends Model
{
    protected $fillable = [
        'chapter_id',
        'rule_code',
        'rule_text',
    ];

    /**
     * Relationship: Jurumiyah Chapter
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(JurumiyahChapter::class, 'chapter_id');
    }
}
