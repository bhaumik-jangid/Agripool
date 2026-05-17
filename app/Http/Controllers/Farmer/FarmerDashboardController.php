<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\PriceProposal;
use App\Models\PoolMember;
use Illuminate\Support\Facades\Auth;

class FarmerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $farmerProfile = $user->farmerProfile;

        $totalRequests = $user->transportRequests()->count();

        $activeRequests = $user->transportRequests()
            ->whereIn('status', [
                'pending',
                'pooled',
                'assigned',
                'in_transit'
            ])->count();

        $completedRequests = $user->transportRequests()
            ->where('status', 'delivered')
            ->count();

        $unreadNotifications = $user->notifications()
            ->where('is_read', false)
            ->count();

        // Get active price proposals for pools this farmer is in
        $myPoolIds = PoolMember::where('user_id', $user->id)
            ->pluck('pool_id');

        $activeProposals = PriceProposal::whereIn('pool_id', $myPoolIds)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->with('driver', 'pool')
            ->get();

        // Store last visit time in session — Unit IV: Sessions
        session(['farmer_last_visit' => now()->toDateTimeString()]);
        $lastVisit = session('farmer_last_visit_previous');
        session(['farmer_last_visit_previous' => now()->toDateTimeString()]);

        return view('farmer.dashboard', compact(
            'user',
            'farmerProfile',
            'totalRequests',
            'activeRequests',
            'completedRequests',
            'unreadNotifications',
            'activeProposals',
            'lastVisit'
        ));
    }
}