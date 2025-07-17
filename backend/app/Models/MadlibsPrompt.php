<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MadlibsPrompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'template_id',
        'word_type',
        'prompt_text',
        'position_in_template',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * The game this prompt belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The template this prompt is based on
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(MadlibsTemplate::class, 'template_id');
    }

    /**
     * Submissions for this prompt
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(MadlibsSubmission::class, 'prompt_id');
    }

    /**
     * Get prompts by word type
     */
    public function scopeByWordType($query, string $wordType)
    {
        return $query->where('word_type', $wordType);
    }

    /**
     * Get required prompts only
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
}
