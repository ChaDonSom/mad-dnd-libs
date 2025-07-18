<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MadlibsTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'template_text',
        'required_word_types',
        'difficulty_level',
        'is_active',
    ];

    protected $casts = [
        'required_word_types' => 'array',
        'is_active' => 'boolean',
    ];

    // Category constants
    const CATEGORY_BIO = 'bio';
    const CATEGORY_JOURNEY = 'journey';
    const CATEGORY_BATTLE = 'battle';

    /**
     * Prompts that use this template
     */
    public function prompts(): HasMany
    {
        return $this->hasMany(MadlibsPrompt::class, 'template_id');
    }

    /**
     * Get templates by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get active templates only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get templates by difficulty
     */
    public function scopeByDifficulty($query, int $level)
    {
        return $query->where('difficulty_level', $level);
    }
}
