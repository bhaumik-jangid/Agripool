<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\DriverProfile;
use App\Models\Vehicle;
use App\Models\TransportRequest;
use App\Models\Pool;
use App\Models\PoolMember;
use App\Models\Shipment;
use App\Models\Notification;
use App\Models\Earning;
use App\Models\Feedback;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding AgriPool database...');

        // ── ADMIN ───────────────────────────────────────────────
        $admin = User::create([
            'name'      => 'AgriPool Admin',
            'email'     => 'admin@agripool.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'phone'     => '9000000001',
            'is_active' => true,
        ]);

        // ── FARMERS ─────────────────────────────────────────────
        $farmersData = [
            [
                'name'     => 'Ramesh Patel',
                'email'    => 'ramesh@farmer.com',
                'phone'    => '9111111111',
                'profile'  => [
                    'farm_name'     => 'Patel Green Farm',
                    'farm_location' => 'Anand Village',
                    'district'      => 'Anand',
                    'state'         => 'Gujarat',
                    'pincode'       => '388001',
                    'latitude'      => 22.5645,
                    'longitude'     => 72.9289,
                    'bio'           => 'Wheat and cotton farmer with 10 years of experience.',
                    'rating'        => 4.5,
                    'total_shipments'=> 12,
                ],
            ],
            [
                'name'     => 'Sunita Devi',
                'email'    => 'sunita@farmer.com',
                'phone'    => '9222222222',
                'profile'  => [
                    'farm_name'     => 'Devi Organic Farm',
                    'farm_location' => 'Borsad Town',
                    'district'      => 'Anand',
                    'state'         => 'Gujarat',
                    'pincode'       => '388540',
                    'latitude'      => 22.4103,
                    'longitude'     => 72.9028,
                    'bio'           => 'Organic vegetable and fruit farmer.',
                    'rating'        => 4.2,
                    'total_shipments'=> 8,
                ],
            ],
            [
                'name'     => 'Vijay Kumar',
                'email'    => 'vijay@farmer.com',
                'phone'    => '9333111111',
                'profile'  => [
                    'farm_name'     => 'Kumar Agri Land',
                    'farm_location' => 'Vadodara Rural',
                    'district'      => 'Vadodara',
                    'state'         => 'Gujarat',
                    'pincode'       => '391101',
                    'latitude'      => 22.3072,
                    'longitude'     => 73.1812,
                    'bio'           => 'Sugarcane and maize farmer.',
                    'rating'        => 3.8,
                    'total_shipments'=> 5,
                ],
            ],
            [
                'name'     => 'Priya Sharma',
                'email'    => 'priya@farmer.com',
                'phone'    => '9444222222',
                'profile'  => [
                    'farm_name'     => 'Sharma Natural Farm',
                    'farm_location' => 'Mehsana Town',
                    'district'      => 'Mehsana',
                    'state'         => 'Gujarat',
                    'pincode'       => '384001',
                    'latitude'      => 23.5880,
                    'longitude'     => 72.3693,
                    'bio'           => 'Onion and potato farmer.',
                    'rating'        => 4.7,
                    'total_shipments'=> 18,
                ],
            ],
        ];

        $farmers = [];
        foreach ($farmersData as $data) {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make('password'),
                'role'      => 'farmer',
                'phone'     => $data['phone'],
                'is_active' => true,
            ]);

            FarmerProfile::create(array_merge(
                ['user_id' => $user->id],
                $data['profile']
            ));

            $farmers[] = $user;
        }

        // ── DRIVERS ─────────────────────────────────────────────
        $driversData = [
            [
                'name'    => 'Mohan Singh',
                'email'   => 'mohan@driver.com',
                'phone'   => '9555333333',
                'profile' => [
                    'license_number'   => 'GJ01-2019-0123456',
                    'license_expiry'   => '2027-12-31',
                    'current_location' => 'Anand, Gujarat',
                    'district'         => 'Anand',
                    'state'            => 'Gujarat',
                    'status'           => 'available',
                    'approval_status'  => 'approved',
                    'rating'           => 4.50,
                    'total_deliveries' => 23,
                    'total_earnings'   => 45000.00,
                ],
                'vehicle' => [
                    'vehicle_type'     => 'Mini Truck',
                    'vehicle_number'   => 'GJ01AB1234',
                    'vehicle_model'    => 'Tata Ace Gold',
                    'capacity_tonnes'  => 1.50,
                    'manufacture_year' => 2019,
                    'insurance_number' => 'INS-GJ-2024-001',
                    'insurance_expiry' => '12/2025',
                    'is_verified'      => true,
                ],
            ],
            [
                'name'    => 'Rajan Mehta',
                'email'   => 'rajan@driver.com',
                'phone'   => '9666444444',
                'profile' => [
                    'license_number'   => 'GJ02-2018-0654321',
                    'license_expiry'   => '2026-06-30',
                    'current_location' => 'Vadodara, Gujarat',
                    'district'         => 'Vadodara',
                    'state'            => 'Gujarat',
                    'status'           => 'available',
                    'approval_status'  => 'approved',
                    'rating'           => 4.20,
                    'total_deliveries' => 15,
                    'total_earnings'   => 28000.00,
                ],
                'vehicle' => [
                    'vehicle_type'     => 'Medium Truck',
                    'vehicle_number'   => 'GJ06CD5678',
                    'vehicle_model'    => 'Mahindra Bolero Pickup',
                    'capacity_tonnes'  => 2.00,
                    'manufacture_year' => 2020,
                    'insurance_number' => 'INS-GJ-2024-002',
                    'insurance_expiry' => '06/2025',
                    'is_verified'      => true,
                ],
            ],
            [
                'name'    => 'Suresh Yadav',
                'email'   => 'suresh@driver.com',
                'phone'   => '9777555555',
                'profile' => [
                    'license_number'   => 'GJ05-2020-0987654',
                    'license_expiry'   => '2028-03-31',
                    'current_location' => 'Surat, Gujarat',
                    'district'         => 'Surat',
                    'state'            => 'Gujarat',
                    'status'           => 'offline',
                    'approval_status'  => 'pending',
                    'rating'           => 0.00,
                    'total_deliveries' => 0,
                    'total_earnings'   => 0.00,
                ],
                'vehicle' => [
                    'vehicle_type'     => 'Tempo',
                    'vehicle_number'   => 'GJ05EF9012',
                    'vehicle_model'    => 'Eicher Pro 1049',
                    'capacity_tonnes'  => 3.00,
                    'manufacture_year' => 2021,
                    'insurance_number' => 'INS-GJ-2024-003',
                    'insurance_expiry' => '03/2026',
                    'is_verified'      => false,
                ],
            ],
        ];

        $drivers = [];
        foreach ($driversData as $data) {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make('password'),
                'role'      => 'driver',
                'phone'     => $data['phone'],
                'is_active' => true,
            ]);

            DriverProfile::create(array_merge(
                ['user_id' => $user->id],
                $data['profile']
            ));

            Vehicle::create(array_merge(
                ['user_id' => $user->id],
                $data['vehicle']
            ));

            $drivers[] = $user;
        }

        // ── TRANSPORT REQUESTS ──────────────────────────────────
        $requests = [];

        // Ramesh — delivered request
        $r1 = TransportRequest::create([
            'user_id'              => $farmers[0]->id,
            'crop_type'            => 'Wheat',
            'quantity_kg'          => 800,
            'packaging_type'       => 'Gunny Bags',
            'pickup_location'      => 'Anand Village, Near Water Tank',
            'pickup_district'      => 'Anand',
            'pickup_state'         => 'Gujarat',
            'destination_market'   => 'Ahmedabad APMC Market',
            'destination_district' => 'Ahmedabad',
            'preferred_pickup_date'=> now()->subDays(10)->toDateString(),
            'preferred_pickup_time'=> '08:00:00',
            'status'               => 'delivered',
            'actual_cost'          => 560.00,
        ]);
        $requests[] = $r1;

        // Ramesh — active pending request
        $r2 = TransportRequest::create([
            'user_id'              => $farmers[0]->id,
            'crop_type'            => 'Cotton',
            'quantity_kg'          => 500,
            'packaging_type'       => 'Loose / Bulk',
            'pickup_location'      => 'Patel Farm, Anand',
            'pickup_district'      => 'Anand',
            'pickup_state'         => 'Gujarat',
            'destination_market'   => 'Surat Cotton Market',
            'destination_district' => 'Surat',
            'preferred_pickup_date'=> now()->addDays(3)->toDateString(),
            'status'               => 'pending',
        ]);
        $requests[] = $r2;

        // Sunita — pooled request
        $r3 = TransportRequest::create([
            'user_id'              => $farmers[1]->id,
            'crop_type'            => 'Tomato',
            'quantity_kg'          => 400,
            'packaging_type'       => 'Plastic Crates',
            'pickup_location'      => 'Borsad Main Road',
            'pickup_district'      => 'Anand',
            'pickup_state'         => 'Gujarat',
            'destination_market'   => 'Ahmedabad APMC Market',
            'destination_district' => 'Ahmedabad',
            'preferred_pickup_date'=> now()->addDays(5)->toDateString(),
            'status'               => 'pooled',
        ]);
        $requests[] = $r3;

        // Vijay — pending
        $r4 = TransportRequest::create([
            'user_id'              => $farmers[2]->id,
            'crop_type'            => 'Sugarcane',
            'quantity_kg'          => 1200,
            'packaging_type'       => 'Loose / Bulk',
            'pickup_location'      => 'Kumar Farm, Vadodara',
            'pickup_district'      => 'Vadodara',
            'pickup_state'         => 'Gujarat',
            'destination_market'   => 'Vadodara APMC',
            'destination_district' => 'Vadodara',
            'preferred_pickup_date'=> now()->addDays(7)->toDateString(),
            'status'               => 'pending',
        ]);
        $requests[] = $r4;

        // Priya — in transit
        $r5 = TransportRequest::create([
            'user_id'              => $farmers[3]->id,
            'crop_type'            => 'Onion',
            'quantity_kg'          => 600,
            'packaging_type'       => 'Gunny Bags',
            'pickup_location'      => 'Sharma Farm, Mehsana',
            'pickup_district'      => 'Mehsana',
            'pickup_state'         => 'Gujarat',
            'destination_market'   => 'Ahmedabad APMC Market',
            'destination_district' => 'Ahmedabad',
            'preferred_pickup_date'=> now()->subDays(1)->toDateString(),
            'status'               => 'in_transit',
        ]);
        $requests[] = $r5;

        // ── POOLS ───────────────────────────────────────────────

        // Pool 1 — open (Sunita's tomato)
        $pool1 = Pool::create([
            'pool_code'          => 'POOL-ANS-001',
            'destination_market' => 'Ahmedabad APMC Market',
            'pickup_region'      => 'Anand',
            'pickup_date'        => now()->addDays(5)->toDateString(),
            'total_capacity_kg'  => 5000,
            'used_capacity_kg'   => 400,
            'total_cost'         => 1349.00,
            'max_farmers'        => 5,
            'status'             => 'open',
            'driver_id'          => null,
        ]);

        PoolMember::create([
            'pool_id'              => $pool1->id,
            'transport_request_id' => $r3->id,
            'user_id'              => $farmers[1]->id,
            'share_percentage'     => 100.00,
            'cost_share'           => 1349.00,
            'joined_at'            => now()->subHours(2),
        ]);

        // Pool 2 — in transit (Priya's onion + Mohan driving)
        $pool2 = Pool::create([
            'pool_code'          => 'POOL-MEH-002',
            'destination_market' => 'Ahmedabad APMC Market',
            'pickup_region'      => 'Mehsana',
            'pickup_date'        => now()->subDays(1)->toDateString(),
            'total_capacity_kg'  => 5000,
            'used_capacity_kg'   => 600,
            'total_cost'         => 980.00,
            'max_farmers'        => 5,
            'status'             => 'in_transit',
            'driver_id'          => $drivers[0]->id,
            'matched_at'         => now()->subDays(2),
        ]);

        PoolMember::create([
            'pool_id'              => $pool2->id,
            'transport_request_id' => $r5->id,
            'user_id'              => $farmers[3]->id,
            'share_percentage'     => 100.00,
            'cost_share'           => 980.00,
            'joined_at'            => now()->subDays(2),
        ]);

        // Create shipment for pool 2
        $shipment2 = Shipment::create([
            'tracking_code'    => 'AGP-MEH20240001',
            'pool_id'          => $pool2->id,
            'driver_id'        => $drivers[0]->id,
            'status'           => 'in_transit',
            'pickup_time'      => now()->subHours(3),
            'current_location' => 'Nadiad Bypass, Gujarat',
            'driver_notes'     => 'On route to Ahmedabad. ETA 2 hours.',
        ]);

        // Pool 3 — completed (Ramesh's wheat delivery)
        $pool3 = Pool::create([
            'pool_code'          => 'POOL-AND-003',
            'destination_market' => 'Ahmedabad APMC Market',
            'pickup_region'      => 'Anand',
            'pickup_date'        => now()->subDays(10)->toDateString(),
            'total_capacity_kg'  => 5000,
            'used_capacity_kg'   => 800,
            'total_cost'         => 1349.00,
            'max_farmers'        => 5,
            'status'             => 'completed',
            'driver_id'          => $drivers[1]->id,
            'matched_at'         => now()->subDays(11),
        ]);

        PoolMember::create([
            'pool_id'              => $pool3->id,
            'transport_request_id' => $r1->id,
            'user_id'              => $farmers[0]->id,
            'share_percentage'     => 100.00,
            'cost_share'           => 560.00,
            'cost_paid'            => true,
            'payment_method'       => 'UPI',
            'has_rated'            => true,
            'driver_rating'        => 4,
            'rating_comment'       => 'Good service, on time delivery.',
            'joined_at'            => now()->subDays(11),
        ]);

        // Completed shipment for pool 3
        $shipment3 = Shipment::create([
            'tracking_code' => 'AGP-AND20240002',
            'pool_id'       => $pool3->id,
            'driver_id'     => $drivers[1]->id,
            'status'        => 'delivered',
            'pickup_time'   => now()->subDays(10)->setHour(8),
            'delivery_time' => now()->subDays(10)->setHour(11),
            'driver_notes'  => 'Delivered successfully.',
            'current_location'=> 'Ahmedabad APMC Market',
        ]);

        // ── EARNINGS ────────────────────────────────────────────
        Earning::create([
            'user_id'        => $drivers[1]->id,
            'shipment_id'    => $shipment3->id,
            'amount'         => 1349.00,
            'payment_method' => 'UPI',
            'status'         => 'paid',
            'paid_at'        => now()->subDays(9),
        ]);

        // ── NOTIFICATIONS ───────────────────────────────────────
        $notifData = [
            [
                'user_id' => $farmers[0]->id,
                'title'   => '🎉 Delivery Complete — Payment Due!',
                'message' => 'Your Wheat has been delivered to Ahmedabad APMC Market. Please confirm payment of ₹560.00.',
                'type'    => 'payment_due',
                'is_read' => true,
                'link'    => '/farmer/requests/' . $r1->id,
            ],
            [
                'user_id' => $farmers[1]->id,
                'title'   => '🤝 Pool Created / Matched',
                'message' => 'A new pool has been created for your Tomato going to Ahmedabad APMC Market.',
                'type'    => 'pool_matched',
                'is_read' => false,
                'link'    => '/farmer/requests/' . $r3->id,
            ],
            [
                'user_id' => $farmers[3]->id,
                'title'   => '🚛 Driver Assigned!',
                'message' => 'Mohan Singh has been assigned to your pool. Track your shipment now.',
                'type'    => 'driver_assigned',
                'is_read' => false,
                'link'    => '/farmer/track/AGP-MEH20240001',
            ],
            [
                'user_id' => $drivers[0]->id,
                'title'   => '⭐ New Rating Received',
                'message' => 'Priya Sharma rated your delivery 5/5.',
                'type'    => 'new_rating',
                'is_read' => false,
                'link'    => '/driver/earnings',
            ],
            [
                'user_id' => $drivers[2]->id,
                'title'   => '⏳ Account Under Review',
                'message' => 'Your driver account is being reviewed by the admin.',
                'type'    => 'account_status',
                'is_read' => true,
                'link'    => '/driver/profile',
            ],
        ];

        foreach ($notifData as $n) {
            Notification::create($n);
        }

        // ── FEEDBACK ────────────────────────────────────────────
        Feedback::create([
            'user_id'     => $farmers[0]->id,
            'shipment_id' => $shipment3->id,
            'driver_id'   => $drivers[1]->id,
            'rating'      => 4,
            'subject'     => 'Good service',
            'message'     => 'Driver was punctual and handled the wheat bags carefully.',
            'type'        => 'rating',
            'status'      => 'resolved',
        ]);

        Feedback::create([
            'user_id'  => $farmers[1]->id,
            'subject'  => 'Request for more vehicles in Anand area',
            'message'  => 'There are not enough drivers available in Anand district during harvest season. Please add more.',
            'type'     => 'suggestion',
            'status'   => 'open',
        ]);

        $this->command->info('');
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('─────────────────────────────────────');
        $this->command->info('  TEST ACCOUNTS (all passwords: password)');
        $this->command->info('─────────────────────────────────────');
        $this->command->info('  Admin:   admin@agripool.com');
        $this->command->info('  Farmer:  ramesh@farmer.com');
        $this->command->info('  Farmer:  sunita@farmer.com');
        $this->command->info('  Farmer:  vijay@farmer.com');
        $this->command->info('  Farmer:  priya@farmer.com');
        $this->command->info('  Driver:  mohan@driver.com  (approved)');
        $this->command->info('  Driver:  rajan@driver.com  (approved)');
        $this->command->info('  Driver:  suresh@driver.com (pending)');
        $this->command->info('─────────────────────────────────────');
        $this->command->info('');
    }
}