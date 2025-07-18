<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Permission;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role and Permission methods
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('slug', $permission);
        })->exists();
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    // Game-related relationships
    
    /**
     * Games hosted by this user
     */
    public function hostedGames(): HasMany
    {
        return $this->hasMany(Game::class, 'host_user_id');
    }

    /**
     * Games this user has participated in
     */
    public function participatedGames(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_participants')
            ->withPivot(['role', 'status', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Madlibs submissions by this user
     */
    public function madlibsSubmissions(): HasMany
    {
        return $this->hasMany(MadlibsSubmission::class);
    }

    /**
     * Player loadouts for this user
     */
    public function playerLoadouts(): HasMany
    {
        return $this->hasMany(PlayerLoadout::class);
    }

    /**
     * Votes cast by this user
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'voter_user_id');
    }

    /**
     * Battle actions performed by this user
     */
    public function battleActions(): HasMany
    {
        return $this->hasMany(BattleAction::class);
    }

    /**
     * Game results where this user was MVP
     */
    public function mvpResults(): HasMany
    {
        return $this->hasMany(GameResult::class, 'mvp_user_id');
    }

    /**
     * Superlatives earned by this user
     */
    public function superlatives(): HasMany
    {
        return $this->hasMany(Superlative::class);
    }

    /**
     * Calling cards for this user
     */
    public function callingCards(): HasMany
    {
        return $this->hasMany(CallingCard::class);
    }

    // Helper methods for game statistics

    /**
     * Get total games played
     */
    public function getTotalGamesPlayed(): int
    {
        return $this->participatedGames()->count();
    }

    /**
     * Get games won
     */
    public function getGamesWon(): int
    {
        return $this->participatedGames()
            ->whereHas('result', function ($query) {
                $query->where('result', GameResult::RESULT_VICTORY);
            })
            ->count();
    }

    /**
     * Get win percentage
     */
    public function getWinPercentage(): float
    {
        $totalGames = $this->getTotalGamesPlayed();
        if ($totalGames === 0) {
            return 0;
        }
        return ($this->getGamesWon() / $totalGames) * 100;
    }

    /**
     * Get total superlatives earned
     */
    public function getTotalSuperlatives(): int
    {
        return $this->superlatives()->count();
    }

    /**
     * Get current active loadout for a game
     */
    public function getCurrentLoadout(Game $game): ?PlayerLoadout
    {
        return $this->playerLoadouts()
            ->where('game_id', $game->id)
            ->where('is_current', true)
            ->first();
    }
}
