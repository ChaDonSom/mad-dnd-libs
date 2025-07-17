<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VoteResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'item_id',
        'item_type',
        'total_score',
        'effectiveness_multiplier',
        'rank_position',
    ];

    protected $casts = [
        'effectiveness_multiplier' => 'decimal:2',
    ];

    /**
     * The game this result belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The item this result is for (polymorphic)
     */
    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get results for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }

    /**
     * Get results by item type
     */
    public function scopeByItemType($query, string $itemType)
    {
        return $query->where('item_type', $itemType);
    }

    /**
     * Get results ordered by rank
     */
    public function scopeOrderedByRank($query)
    {
        return $query->orderBy('rank_position');
    }

    /**
     * Get top performers only
     */
    public function scopeTopPerformers($query, int $limit = 3)
    {
        return $query->orderBy('rank_position')->limit($limit);
    }
}
