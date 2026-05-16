<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipment_id',
        'amount',
        'payment_method',
        'status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}