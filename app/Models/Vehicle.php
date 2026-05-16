<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_type',
        'vehicle_number',
        'vehicle_model',
        'capacity_tonnes',
        'manufacture_year',
        'insurance_number',
        'insurance_expiry',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'capacity_tonnes' => 'decimal:2',
    ];

    // Vehicle belongs to one driver (user)
    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}