<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'pool_id',
        'transport_request_id',
        'user_id',
        'share_percentage',
        'cost_share',
        'cost_paid',
        'joined_at',
    ];

    protected $casts = [
        'cost_paid' => 'boolean',
        'joined_at' => 'datetime',
        'share_percentage' => 'decimal:2',
        'cost_share' => 'decimal:2',
    ];

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function transportRequest()
    {
        return $this->belongsTo(TransportRequest::class);
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}