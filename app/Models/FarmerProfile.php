<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'farm_name',
        'farm_location',
        'district',
        'state',
        'pincode',
        'latitude',
        'longitude',
        'bio',
        'total_shipments',
        'rating',
    ];

    // This farmer profile belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}