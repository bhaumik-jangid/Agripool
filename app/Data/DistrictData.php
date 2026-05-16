<?php

namespace App\Data;

class DistrictData
{
    // Gujarat districts with approximate coordinates
    public static array $districts = [
        'Ahmedabad'     => ['lat' => 23.0225, 'lng' => 72.5714],
        'Surat'         => ['lat' => 21.1702, 'lng' => 72.8311],
        'Vadodara'      => ['lat' => 22.3072, 'lng' => 73.1812],
        'Rajkot'        => ['lat' => 22.3039, 'lng' => 70.8022],
        'Bhavnagar'     => ['lat' => 21.7645, 'lng' => 72.1519],
        'Jamnagar'      => ['lat' => 22.4707, 'lng' => 70.0577],
        'Junagadh'      => ['lat' => 21.5222, 'lng' => 70.4579],
        'Gandhinagar'   => ['lat' => 23.2156, 'lng' => 72.6369],
        'Anand'         => ['lat' => 22.5645, 'lng' => 72.9289],
        'Mehsana'       => ['lat' => 23.5880, 'lng' => 72.3693],
        'Patan'         => ['lat' => 23.8493, 'lng' => 72.1266],
        'Banaskantha'   => ['lat' => 24.1700, 'lng' => 72.4300],
        'Sabarkantha'   => ['lat' => 23.5800, 'lng' => 73.0100],
        'Kheda'         => ['lat' => 22.7500, 'lng' => 72.6800],
        'Panchmahal'    => ['lat' => 22.7200, 'lng' => 73.5200],
        'Dahod'         => ['lat' => 22.8350, 'lng' => 74.2570],
        'Narmada'       => ['lat' => 21.8700, 'lng' => 73.5000],
        'Bharuch'       => ['lat' => 21.7051, 'lng' => 72.9959],
        'Navsari'       => ['lat' => 20.9467, 'lng' => 72.9520],
        'Valsad'        => ['lat' => 20.5992, 'lng' => 72.9342],
        'Dang'          => ['lat' => 20.7500, 'lng' => 73.6900],
        'Tapi'          => ['lat' => 21.1200, 'lng' => 73.4100],
        'Kutch'         => ['lat' => 23.7337, 'lng' => 69.8597],
        'Surendranagar' => ['lat' => 22.7270, 'lng' => 71.6490],
        'Morbi'         => ['lat' => 22.8173, 'lng' => 70.8370],
        'Botad'         => ['lat' => 22.1693, 'lng' => 71.6653],
        'Gir Somnath'   => ['lat' => 20.9000, 'lng' => 70.3700],
        'Amreli'        => ['lat' => 21.6037, 'lng' => 71.2210],
        'Porbandar'     => ['lat' => 21.6417, 'lng' => 69.6293],
        'Devbhoomi Dwarka' => ['lat' => 22.2320, 'lng' => 68.9680],
    ];

    // Base rate per km per tonne (in rupees)
    const RATE_PER_KM_PER_TONNE = 12.0;

    // Minimum charge
    const MINIMUM_CHARGE = 500.0;

    // Full truck capacity in tonnes
    const TRUCK_CAPACITY_TONNES = 5.0;

    /**
     * Calculate distance between two districts using Haversine formula
     * Returns distance in km
     */
    public static function distanceBetween(
        string $fromDistrict,
        string $toDistrict
    ): float {
        if (!isset(self::$districts[$fromDistrict])
            || !isset(self::$districts[$toDistrict])) {
            return 100; // Default fallback distance
        }

        $from = self::$districts[$fromDistrict];
        $to   = self::$districts[$toDistrict];

        $earthRadius = 6371; // km

        $latDiff = deg2rad($to['lat'] - $from['lat']);
        $lngDiff = deg2rad($to['lng'] - $from['lng']);

        $a = sin($latDiff / 2) * sin($latDiff / 2)
           + cos(deg2rad($from['lat']))
           * cos(deg2rad($to['lat']))
           * sin($lngDiff / 2)
           * sin($lngDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    /**
     * Calculate full truck transport cost based on distance
     */
    public static function calculateTruckCost(
        string $fromDistrict,
        string $toDistrict
    ): float {
        $distance = self::distanceBetween($fromDistrict, $toDistrict);
        $cost = $distance
                * self::TRUCK_CAPACITY_TONNES
                * self::RATE_PER_KM_PER_TONNE;

        return max(round($cost, 2), self::MINIMUM_CHARGE);
    }

    public static function getDistrictNames(): array
    {
        return array_keys(self::$districts);
    }
}