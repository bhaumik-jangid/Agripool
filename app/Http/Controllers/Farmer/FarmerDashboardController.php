<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $farmerProfile = $user->farmerProfile;

        // Count stats for dashboard cards
        $totalRequests = $user->transportRequests()->count();
        $activeRequests = $user->transportRequests()
                               ->whereIn('status', ['pending', 'pooled', 'assigned', 'in_transit'])
                               ->count();
        $completedRequests = $user->transportRequests()
                                  ->where('status', 'delivered')
                                  ->count();
        $unreadNotifications = $user->notifications()
                                    ->where('is_read', false)
                                    ->count();

        return view('farmer.dashboard', compact(
            'user',
            'farmerProfile',
            'totalRequests',
            'activeRequests',
            'completedRequests',
            'unreadNotifications'
        ));
    }
}