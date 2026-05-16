<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TransportRequest;
use App\Models\Pool;
use App\Models\Shipment;
use App\Models\Feedback;
use App\Models\DriverProfile;
use App\Models\Earning;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Platform stats ────────────────────────────────────
        $totalFarmers = User::where('role', 'farmer')->count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalRequests = TransportRequest::count();
        $totalPools = Pool::count();

        $activePools = Pool::whereIn(
            'status',
            ['open', 'full', 'assigned', 'in_transit']
        )->count();

        $completedDeliveries = Shipment::where('status', 'delivered')->count();

        $pendingApprovals = DriverProfile::where('approval_status', 'pending')
            ->count();

        $totalEarnings = Earning::where('status', 'paid')->sum('amount');

        $openFeedback = Feedback::where('status', 'open')->count();

        // ── Recent activity ───────────────────────────────────
        $recentRequests = TransportRequest::with('farmer')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $recentDrivers = User::where('role', 'driver')
            ->with('driverProfile')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $pendingDriversList = User::where('role', 'driver')
            ->whereHas('driverProfile', function ($q) {
                $q->where('approval_status', 'pending');
            })
            ->with('driverProfile')
            ->take(5)
            ->get();

        // ── Chart data: requests per day (last 7 days) ────────
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[] = [
                'date' => now()->subDays($i)->format('d M'),
                'count' => TransportRequest::whereDate('created_at', $date)->count(),
            ];
        }

        // Calculate max separately — fixes the PHP max() array error
        $maxChartCount = 0;
        foreach ($chartData as $day) {
            if ($day['count'] > $maxChartCount) {
                $maxChartCount = $day['count'];
            }
        }
        if ($maxChartCount === 0)
            $maxChartCount = 1;

        return view('admin.dashboard', compact(
            'totalFarmers',
            'totalDrivers',
            'totalRequests',
            'totalPools',
            'activePools',
            'completedDeliveries',
            'pendingApprovals',
            'totalEarnings',
            'openFeedback',
            'recentRequests',
            'recentDrivers',
            'pendingDriversList',
            'chartData',
            'maxChartCount'
        ));
    }

    // Suspend a user account
    public function suspend(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend an admin account.');
        }

        $user->update(['is_active' => false]);

        AdminLog::create([
            'user_id' => Auth::id(),
            'action' => 'suspend_user',
            'target_type' => 'user',
            'target_id' => $user->id,
            'description' => 'Suspended user: ' . $user->email,
            'ip_address' => request()->ip(),
        ]);

        return back()->with(
            'success',
            $user->name . '\'s account has been suspended.'
        );
    }

    // Reactivate a suspended user
    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        AdminLog::create([
            'user_id' => Auth::id(),
            'action' => 'activate_user',
            'target_type' => 'user',
            'target_id' => $user->id,
            'description' => 'Activated user: ' . $user->email,
            'ip_address' => request()->ip(),
        ]);

        return back()->with(
            'success',
            $user->name . '\'s account has been reactivated.'
        );
    }
}