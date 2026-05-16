<?php

namespace App\Services;

use App\Models\Pool;
use App\Models\PoolMember;
use App\Models\TransportRequest;
use App\Models\Notification;
use Illuminate\Support\Str;

class PoolMatchingService
{
    // Base truck cost per trip (can be made configurable later)
    const FULL_TRUCK_COST = 3500.00;
    const TRUCK_CAPACITY_KG = 5000;

    /**
     * Find a matching pool for this request.
     * Returns the pool if found, null if no match.
     * Does NOT join automatically — farmer must confirm.
     */
    public function findMatch(TransportRequest $request): ?Pool
    {
        return Pool::where('status', 'open')
            ->where(function ($q) use ($request) {
                $q->where('destination_market', 'like',
                      '%' . $request->destination_district . '%')
                  ->orWhere('pickup_region', 'like',
                      '%' . $request->pickup_district . '%');
            })
            ->whereBetween('pickup_date', [
                $request->preferred_pickup_date->copy()->subDay(),
                $request->preferred_pickup_date->copy()->addDay(),
            ])
            ->whereRaw('(total_capacity_kg - used_capacity_kg) >= ?',
                [$request->quantity_kg])
            ->whereNull('driver_id')
            ->first();
    }

    /**
     * Farmer chose to JOIN the pool (shared, pay proportionally).
     */
    public function joinPool(Pool $pool, TransportRequest $request): void
    {
        PoolMember::create([
            'pool_id'              => $pool->id,
            'transport_request_id' => $request->id,
            'user_id'              => $request->user_id,
            'joined_at'            => now(),
        ]);

        $pool->increment('used_capacity_kg', $request->quantity_kg);
        $request->update(['status' => 'pooled']);

        if ($pool->members()->count() >= $pool->max_farmers) {
            $pool->update(['status' => 'full']);
        }

        $this->recalculateCostShares($pool);
        $this->notifyFarmer($pool, $request, 'shared');
    }

    /**
     * Farmer chose to go SOLO (full truck, full cost).
     * Create a new private pool just for them.
     */
    public function goSolo(TransportRequest $request): Pool
    {
        // Create a private pool locked to this farmer only
        $pool = Pool::create([
            'pool_code'         => 'SOLO-' . strtoupper(Str::random(8)),
            'destination_market'=> $request->destination_market,
            'pickup_region'     => $request->pickup_district,
            'pickup_date'       => $request->preferred_pickup_date,
            'total_capacity_kg' => self::TRUCK_CAPACITY_KG,
            'used_capacity_kg'  => $request->quantity_kg,
            'total_cost'        => self::FULL_TRUCK_COST,
            'max_farmers'       => 1, // solo — no one else can join
            'status'            => 'open',
            'driver_id'         => null,
        ]);

        PoolMember::create([
            'pool_id'              => $pool->id,
            'transport_request_id' => $request->id,
            'user_id'              => $request->user_id,
            'share_percentage'     => 100.00,
            'cost_share'           => self::FULL_TRUCK_COST,
            'joined_at'            => now(),
        ]);

        $request->update(['status' => 'pooled']);
        $this->notifyFarmer($pool, $request, 'solo');

        return $pool;
    }

    /**
     * Create a brand new shared pool (when no match exists).
     * Farmer is first member, waits for others to join.
     */
    public function createNewPool(TransportRequest $request): Pool
    {
        $pool = Pool::create([
            'pool_code'         => 'POOL-' . strtoupper(Str::random(8)),
            'destination_market'=> $request->destination_market,
            'pickup_region'     => $request->pickup_district,
            'pickup_date'       => $request->preferred_pickup_date,
            'total_capacity_kg' => self::TRUCK_CAPACITY_KG,
            'used_capacity_kg'  => $request->quantity_kg,
            'total_cost'        => self::FULL_TRUCK_COST,
            'max_farmers'       => 5,
            'status'            => 'open',
            'driver_id'         => null,
        ]);

        PoolMember::create([
            'pool_id'              => $pool->id,
            'transport_request_id' => $request->id,
            'user_id'              => $request->user_id,
            'joined_at'            => now(),
        ]);

        $request->update(['status' => 'pooled']);
        $this->recalculateCostShares($pool);
        $this->notifyFarmer($pool, $request, 'new');

        return $pool;
    }

    /**
     * Recalculate cost share for every farmer in the pool
     * based on how much of the truck capacity they are using.
     *
     * Formula: (farmer_kg / total_used_kg) * total_truck_cost
     */
    public function recalculateCostShares(Pool $pool): void
    {
        $pool->refresh();

        if (!$pool->total_cost || $pool->used_capacity_kg <= 0) {
            return;
        }

        foreach ($pool->members as $member) {
            $farmerKg     = $member->transportRequest->quantity_kg ?? 0;
            $sharePercent = round(
                ($farmerKg / $pool->used_capacity_kg) * 100, 2
            );
            $costShare    = round(
                ($sharePercent / 100) * $pool->total_cost, 2
            );

            $member->update([
                'share_percentage' => $sharePercent,
                'cost_share'       => $costShare,
            ]);
        }
    }

    /**
     * Calculate what this farmer would pay if they join a shared pool.
     * Used in the confirmation popup to show estimated cost.
     */
    public function calculateSharedCost(Pool $pool, float $farmerKg): array
    {
        $newUsed      = $pool->used_capacity_kg + $farmerKg;
        $sharePercent = round(($farmerKg / $newUsed) * 100, 2);
        $cost         = round(($sharePercent / 100) * $pool->total_cost, 2);

        return [
            'share_percent' => $sharePercent,
            'cost'          => $cost,
            'saving'        => round($pool->total_cost - $cost, 2),
        ];
    }

    private function notifyFarmer(
        Pool $pool,
        TransportRequest $request,
        string $type
    ): void {
        $messages = [
            'shared' => 'You joined a shared pool going to '
                        . $pool->destination_market
                        . '. A driver will be assigned soon.',
            'solo'   => 'Your solo transport pool has been created for '
                        . $request->crop_type . ' going to '
                        . $request->destination_market
                        . '. Full truck reserved for you.',
            'new'    => 'A new pool has been created for your '
                        . $request->crop_type
                        . '. Waiting for more farmers or a driver.',
        ];

        Notification::create([
            'user_id' => $request->user_id,
            'title'   => $type === 'solo'
                ? '🚛 Solo Transport Booked'
                : '🤝 Pool Created / Matched',
            'message' => $messages[$type],
            'type'    => 'pool_matched',
            'link'    => '/farmer/requests/' . $request->id,
        ]);
    }
}