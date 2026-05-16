<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crop_type',
        'quantity_kg',
        'packaging_type',
        'pickup_location',
        'pickup_district',
        'pickup_state',
        'pickup_latitude',
        'pickup_longitude',
        'destination_market',
        'destination_district',
        'preferred_pickup_date',
        'preferred_pickup_time',
        'estimated_cost',
        'actual_cost',
        'status',
        'special_instructions',
    ];

    protected $casts = [
        'preferred_pickup_date' => 'date',
        'quantity_kg' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
    ];

    // Transport request belongs to one farmer (user)
    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A request can be part of one pool (through pool_members)
    public function poolMember()
    {
        return $this->hasOne(PoolMember::class);
    }

    // Helper to check if this request is still editable
    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'pooled']);
    }
}