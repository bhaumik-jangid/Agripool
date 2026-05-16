<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = [
        'pool_code',
        'destination_market',
        'pickup_region',
        'pickup_date',
        'total_capacity_kg',
        'used_capacity_kg',
        'total_cost',
        'max_farmers',
        'status',
        'driver_id',
        'matched_at',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'matched_at' => 'datetime',
        'total_capacity_kg' => 'decimal:2',
        'used_capacity_kg' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    // Pool has many pool members (farmers in it)
    public function members()
    {
        return $this->hasMany(PoolMember::class);
    }

    // Pool belongs to one driver
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Pool has one shipment
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    // How much space is still available in kg
    public function availableCapacity(): float
    {
        return $this->total_capacity_kg - $this->used_capacity_kg;
    }

    // Is the pool still accepting farmers
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}