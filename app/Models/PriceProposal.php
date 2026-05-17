<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceProposal extends Model
{
    protected $fillable = [
        'pool_id', 'driver_id', 'original_cost',
        'proposed_cost', 'reason', 'status', 'expires_at',
    ];

    protected $casts = [
        'expires_at'    => 'datetime',
        'original_cost' => 'decimal:2',
        'proposed_cost' => 'decimal:2',
    ];

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function votes()
    {
        return $this->hasMany(PriceProposalVote::class);
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }

    // Check if farmer has already voted
    public function hasVoted(int $userId): bool
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    // Get farmer's vote
    public function getVote(int $userId): ?string
    {
        return $this->votes()->where('user_id', $userId)
                             ->value('vote');
    }

    // Check if majority accepted
    public function isMajorityAccepted(): bool
    {
        $total   = $this->pool->members()->count();
        $accepts = $this->votes()->where('vote', 'accept')->count();
        return $total > 0 && ($accepts / $total) > 0.5;
    }

    // Check if majority declined
    public function isMajorityDeclined(): bool
    {
        $total    = $this->pool->members()->count();
        $declines = $this->votes()->where('vote', 'decline')->count();
        return $total > 0 && ($declines / $total) > 0.5;
    }
}