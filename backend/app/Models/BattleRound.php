<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BattleRound extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'round_number',
        'current_turn',
        'status',
    ];

    // Status constants
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    /**
     * The game this round belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Actions taken in this round
     */
    public function battleActions(): HasMany
    {
        return $this->hasMany(BattleAction::class, 'round_id');
    }

    /**
     * Get in-progress rounds only
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Get completed rounds only
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Get total damage dealt in this round
     */
    public function getTotalDamage(): int
    {
        return $this->battleActions()->sum('total_damage');
    }

    /**
     * Complete this round
     */
    public function complete(): void
    {
        $this->status = self::STATUS_COMPLETED;
        $this->save();
    }
}
