<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignment protection — only these fields can be filled via form
    // In MERN, this is like specifying which fields Mongoose allows to be set
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_photo',
        'is_active',
    ];

    // These fields are never included in JSON output (like toJSON transform in Mongoose)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Type casting — automatically convert these to the right PHP type
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ==================== ROLE HELPERS ====================
    // Simple methods to check user role anywhere in the app

    public function isFarmer(): bool
    {
        return $this->role === 'farmer';
    }

    public function isDriver(): bool
    {
        return $this->role === 'driver';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ==================== RELATIONSHIPS ====================
    // In Mongoose, you use populate(). In Eloquent, you define relationship methods.

    // One user (farmer) has one farmer profile
    public function farmerProfile()
    {
        return $this->hasOne(FarmerProfile::class);
    }

    // One user (driver) has one driver profile
    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class);
    }

    // One user (driver) has one vehicle
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    // One farmer has many transport requests
    public function transportRequests()
    {
        return $this->hasMany(TransportRequest::class);
    }

    // One user has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // One driver has many earnings
    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    // One user has many feedback submissions
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}