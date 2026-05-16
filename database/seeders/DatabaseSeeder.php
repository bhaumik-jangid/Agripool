<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\DriverProfile;
use App\Models\Vehicle;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== CREATE ADMIN =====
        $admin = User::create([
            'name' => 'AgriPool Admin',
            'email' => 'admin@agripool.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '9000000001',
            'is_active' => true,
        ]);

        // ===== CREATE FARMERS =====
        $farmer1 = User::create([
            'name' => 'Ramesh Patel',
            'email' => 'ramesh@farmer.com',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'phone' => '9111111111',
            'is_active' => true,
        ]);

        FarmerProfile::create([
            'user_id' => $farmer1->id,
            'farm_name' => 'Patel Green Farm',
            'farm_location' => 'Anand Village',
            'district' => 'Anand',
            'state' => 'Gujarat',
            'pincode' => '388001',
            'latitude' => 22.5645,
            'longitude' => 72.9289,
            'bio' => 'Wheat and cotton farmer with 10 years experience.',
        ]);

        $farmer2 = User::create([
            'name' => 'Sunita Devi',
            'email' => 'sunita@farmer.com',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'phone' => '9222222222',
            'is_active' => true,
        ]);

        FarmerProfile::create([
            'user_id' => $farmer2->id,
            'farm_name' => 'Devi Organic Farm',
            'farm_location' => 'Borsad Town',
            'district' => 'Anand',
            'state' => 'Gujarat',
            'pincode' => '388540',
            'latitude' => 22.4103,
            'longitude' => 72.9028,
            'bio' => 'Organic vegetable farmer.',
        ]);

        // ===== CREATE DRIVER =====
        $driver = User::create([
            'name' => 'Mohan Singh',
            'email' => 'mohan@driver.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'phone' => '9333333333',
            'is_active' => true,
        ]);

        DriverProfile::create([
            'user_id' => $driver->id,
            'license_number' => 'GJ01-2019-0123456',
            'license_expiry' => '2027-12-31',
            'current_location' => 'Anand, Gujarat',
            'district' => 'Anand',
            'state' => 'Gujarat',
            'status' => 'available',
            'approval_status' => 'approved',
            'rating' => 4.50,
            'total_deliveries' => 23,
            'total_earnings' => 45000.00,
        ]);

        Vehicle::create([
            'user_id' => $driver->id,
            'vehicle_type' => 'Mini Truck',
            'vehicle_number' => 'GJ01AB1234',
            'vehicle_model' => 'Tata Ace',
            'capacity_tonnes' => 1.50,
            'manufacture_year' => 2019,
            'is_verified' => true,
        ]);

        $this->command->info('✅ Sample data seeded successfully!');
        $this->command->info('Admin: admin@agripool.com / password');
        $this->command->info('Farmer: ramesh@farmer.com / password');
        $this->command->info('Driver: mohan@driver.com / password');


        \App\Models\Pool::create([
            'pool_code' => 'POOL-2024-001',
            'destination_market' => 'Ahmedabad APMC Market',
            'pickup_region' => 'Anand District',
            'pickup_date' => now()->addDays(3)->format('Y-m-d'),
            'total_capacity_kg' => 5000,
            'used_capacity_kg' => 1200,
            'total_cost' => 3500.00,
            'max_farmers' => 5,
            'status' => 'open',
            'driver_id' => null,
        ]);
    }


}