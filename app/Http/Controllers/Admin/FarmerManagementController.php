<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class FarmerManagementController extends Controller
{
    public function index()
    {
        $farmers = User::where('role', 'farmer')
                       ->with('farmerProfile')
                       ->withCount('transportRequests')
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        return view('admin.farmers.index', compact('farmers'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'farmer') {
            abort(404);
        }

        $user->load('farmerProfile');

        $requests = $user->transportRequests()
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        $stats = [
            'total'     => $user->transportRequests()->count(),
            'delivered' => $user->transportRequests()
                                ->where('status', 'delivered')->count(),
            'active'    => $user->transportRequests()
                                ->whereIn('status',
                                    ['pending','pooled','assigned','in_transit'])
                                ->count(),
            'cancelled' => $user->transportRequests()
                                ->where('status', 'cancelled')->count(),
        ];

        return view('admin.farmers.show',
            compact('user', 'requests', 'stats'));
    }
}