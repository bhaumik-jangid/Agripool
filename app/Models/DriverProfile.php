<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'license_expiry',
        'current_location',
        'district',
        'state',
        'status',
        'approval_status',
        'rating',
        'total_deliveries',
        'total_earnings',
        'rejection_reason',
    ];

    // Driver profile belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check if driver is approved by admin
    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }
}