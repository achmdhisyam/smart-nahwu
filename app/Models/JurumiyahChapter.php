<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JurumiyahChapter extends Model
{
    protected $fillable = [
        'parent_id',
        'title',
        'definition',
        'order_num',
    ];

    /**
     * Relationship: Self-referencing parent
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Relationship: Self-referencing children (sub-chapters)
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order_num');
    }

    /**
     * Relationship: Grammar Rules
     */
    public function grammarRules(): HasMany
    {
        return $this->hasMany(GrammarRule::class, 'chapter_id');
    }

    /**
     * Relationship: Grammar Examples
     */
    public function grammarExamples(): HasMany
    {
        return $this->hasMany(GrammarExample::class, 'chapter_id');
    }

    /**
     * Relationship: Arabic Particles
     */
    public function arabicParticles(): HasMany
    {
        return $this->hasMany(ArabicParticle::class, 'chapter_id');
    }

    /**
     * Relationship: Generated Quizzes
     */
    public function generatedQuizzes(): HasMany
    {
        return $this->hasMany(GeneratedQuiz::class, 'chapter_id');
    }

    /**
     * Scope: Root chapters (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id')->orderBy('order_num');
    }
}
