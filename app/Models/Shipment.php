<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'pool_id',
        'driver_id',
        'status',
        'pickup_time',
        'delivery_time',
        'current_location',
        'driver_notes',
        'total_distance_km',
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
        'delivery_time' => 'datetime',
        'total_distance_km' => 'decimal:2',
    ];

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}