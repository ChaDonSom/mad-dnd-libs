<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boss extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'description',
        'max_health',
        'current_health',
        'image_url',
        'special_abilities',
    ];

    protected $casts = [
        'special_abilities' => 'array',
    ];

    /**
     * The game this boss belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Check if boss is defeated
     */
    public function isDefeated(): bool
    {
        return $this->current_health <= 0;
    }

    /**
     * Take damage
     */
    public function takeDamage(int $damage): void
    {
        $this->current_health = max(0, $this->current_health - $damage);
        $this->save();
    }

    /**
     * Get health percentage
     */
    public function getHealthPercentage(): float
    {
        if ($this->max_health <= 0) {
            return 0;
        }
        return ($this->current_health / $this->max_health) * 100;
    }
}
