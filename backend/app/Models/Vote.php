<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'voter_user_id',
        'category',
        'voted_item_id',
        'voted_item_type',
        'rank',
    ];

    // Category constants
    const CATEGORY_CHARACTER = 'character';
    const CATEGORY_WEAPON = 'weapon';
    const CATEGORY_ATTACK = 'attack';

    /**
     * The game this vote belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The user who cast this vote
     */
    public function voter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voter_user_id');
    }

    /**
     * The item being voted on (polymorphic)
     */
    public function votedItem(): MorphTo
    {
        return $this->morphTo('voted_item');
    }

    /**
     * Get votes by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get votes for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }

    /**
     * Get votes by rank
     */
    public function scopeByRank($query, int $rank)
    {
        return $query->where('rank', $rank);
    }

    /**
     * Get first place votes
     */
    public function scopeFirstPlace($query)
    {
        return $query->where('rank', 1);
    }
}
