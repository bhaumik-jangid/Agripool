<?php

namespace App\Data;

class DistrictData
{
    public static array $districts = [
        'Ahmedabad'        => ['lat' => 23.0225, 'lng' => 72.5714, 'state' => 'Gujarat'],
        'Surat'            => ['lat' => 21.1702, 'lng' => 72.8311, 'state' => 'Gujarat'],
        'Vadodara'         => ['lat' => 22.3072, 'lng' => 73.1812, 'state' => 'Gujarat'],
        'Rajkot'           => ['lat' => 22.3039, 'lng' => 70.8022, 'state' => 'Gujarat'],
        'Bhavnagar'        => ['lat' => 21.7645, 'lng' => 72.1519, 'state' => 'Gujarat'],
        'Jamnagar'         => ['lat' => 22.4707, 'lng' => 70.0577, 'state' => 'Gujarat'],
        'Junagadh'         => ['lat' => 21.5222, 'lng' => 70.4579, 'state' => 'Gujarat'],
        'Gandhinagar'      => ['lat' => 23.2156, 'lng' => 72.6369, 'state' => 'Gujarat'],
        'Anand'            => ['lat' => 22.5645, 'lng' => 72.9289, 'state' => 'Gujarat'],
        'Mehsana'          => ['lat' => 23.5880, 'lng' => 72.3693, 'state' => 'Gujarat'],
        'Patan'            => ['lat' => 23.8493, 'lng' => 72.1266, 'state' => 'Gujarat'],
        'Banaskantha'      => ['lat' => 24.1700, 'lng' => 72.4300, 'state' => 'Gujarat'],
        'Sabarkantha'      => ['lat' => 23.5800, 'lng' => 73.0100, 'state' => 'Gujarat'],
        'Kheda'            => ['lat' => 22.7500, 'lng' => 72.6800, 'state' => 'Gujarat'],
        'Panchmahal'       => ['lat' => 22.7200, 'lng' => 73.5200, 'state' => 'Gujarat'],
        'Dahod'            => ['lat' => 22.8350, 'lng' => 74.2570, 'state' => 'Gujarat'],
        'Narmada'          => ['lat' => 21.8700, 'lng' => 73.5000, 'state' => 'Gujarat'],
        'Bharuch'          => ['lat' => 21.7051, 'lng' => 72.9959, 'state' => 'Gujarat'],
        'Navsari'          => ['lat' => 20.9467, 'lng' => 72.9520, 'state' => 'Gujarat'],
        'Valsad'           => ['lat' => 20.5992, 'lng' => 72.9342, 'state' => 'Gujarat'],
        'Dang'             => ['lat' => 20.7500, 'lng' => 73.6900, 'state' => 'Gujarat'],
        'Tapi'             => ['lat' => 21.1200, 'lng' => 73.4100, 'state' => 'Gujarat'],
        'Kutch'            => ['lat' => 23.7337, 'lng' => 69.8597, 'state' => 'Gujarat'],
        'Surendranagar'    => ['lat' => 22.7270, 'lng' => 71.6490, 'state' => 'Gujarat'],
        'Morbi'            => ['lat' => 22.8173, 'lng' => 70.8370, 'state' => 'Gujarat'],
        'Botad'            => ['lat' => 22.1693, 'lng' => 71.6653, 'state' => 'Gujarat'],
        'Gir Somnath'      => ['lat' => 20.9000, 'lng' => 70.3700, 'state' => 'Gujarat'],
        'Amreli'           => ['lat' => 21.6037, 'lng' => 71.2210, 'state' => 'Gujarat'],
        'Porbandar'        => ['lat' => 21.6417, 'lng' => 69.6293, 'state' => 'Gujarat'],
        'Devbhoomi Dwarka' => ['lat' => 22.2320, 'lng' => 68.9680, 'state' => 'Gujarat'],
    ];

    const RATE_PER_KM_PER_TONNE = 12.0;
    const MINIMUM_CHARGE        = 500.0;
    const TRUCK_CAPACITY_TONNES = 5.0;

    public static function distanceBetween(
        string $fromDistrict,
        string $toDistrict
    ): float {
        if (!isset(self::$districts[$fromDistrict])
            || !isset(self::$districts[$toDistrict])) {
            return 100;
        }

        $from = self::$districts[$fromDistrict];
        $to   = self::$districts[$toDistrict];

        $earthRadius = 6371;
        $latDiff = deg2rad($to['lat'] - $from['lat']);
        $lngDiff = deg2rad($to['lng'] - $from['lng']);

        $a = sin($latDiff / 2) * sin($latDiff / 2)
           + cos(deg2rad($from['lat']))
           * cos(deg2rad($to['lat']))
           * sin($lngDiff / 2)
           * sin($lngDiff / 2);

        return round($earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a)), 2);
    }

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

    public static function getStateForDistrict(string $district): string
    {
        return self::$districts[$district]['state'] ?? 'Gujarat';
    }

    public static function getDistrictNames(): array
    {
        return array_keys(self::$districts);
    }
}