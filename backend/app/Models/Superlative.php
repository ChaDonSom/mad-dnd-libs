<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Superlative extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'category',
        'title',
        'description',
    ];

    // Superlative category constants
    const CATEGORY_MOST_CREATIVE = 'most_creative';
    const CATEGORY_HIGHEST_DAMAGE = 'highest_damage';
    const CATEGORY_FUNNIEST = 'funniest';
    const CATEGORY_MOST_VOTES = 'most_votes';
    const CATEGORY_BEST_TEAMWORK = 'best_teamwork';
    const CATEGORY_LUCKIEST = 'luckiest';

    /**
     * The game this superlative belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The user who received this superlative
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get superlatives by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get superlatives for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }

    /**
     * Get superlatives for a specific user
     */
    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
