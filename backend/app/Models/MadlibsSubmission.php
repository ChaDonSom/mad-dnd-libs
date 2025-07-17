<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MadlibsSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'prompt_id',
        'submitted_word',
        'is_validated',
        'submitted_at',
    ];

    protected $casts = [
        'is_validated' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    /**
     * The game this submission belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The user who made this submission
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The prompt this submission responds to
     */
    public function prompt(): BelongsTo
    {
        return $this->belongsTo(MadlibsPrompt::class, 'prompt_id');
    }

    /**
     * Get validated submissions only
     */
    public function scopeValidated($query)
    {
        return $query->where('is_validated', true);
    }

    /**
     * Get submissions by user
     */
    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Get submissions for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }
}
