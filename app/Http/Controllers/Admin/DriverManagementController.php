<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverProfile;
use App\Models\AdminLog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverManagementController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')
                       ->with('driverProfile', 'vehicle')
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        $pendingCount = DriverProfile::where('approval_status', 'pending')
                                     ->count();

        return view('admin.drivers.index',
            compact('drivers', 'pendingCount'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'driver') {
            abort(404);
        }

        $user->load('driverProfile', 'vehicle');

        $shipments = \App\Models\Shipment::where('driver_id', $user->id)
                         ->with('pool')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('admin.drivers.show',
            compact('user', 'shipments'));
    }

    // Approve a driver
    public function approve(User $user)
    {
        $profile = $user->driverProfile;

        if (!$profile) {
            return back()->with('error', 'Driver profile not found.');
        }

        $profile->update([
            'approval_status'  => 'approved',
            'rejection_reason' => null,
        ]);

        // Notify the driver
        Notification::create([
            'user_id' => $user->id,
            'title'   => '🎉 Account Approved!',
            'message' => 'Congratulations! Your driver account has been approved. '
                         . 'You can now browse and accept delivery pools.',
            'type'    => 'account_approved',
            'link'    => '/driver/pools',
        ]);

        // Log the action
        AdminLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'approve_driver',
            'target_type' => 'user',
            'target_id'   => $user->id,
            'description' => 'Approved driver: ' . $user->email,
            'ip_address'  => request()->ip(),
        ]);

        return back()->with('success',
            $user->name . ' has been approved as a driver.');
    }

    // Reject a driver with reason
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10'],
        ]);

        $profile = $user->driverProfile;

        if (!$profile) {
            return back()->with('error', 'Driver profile not found.');
        }

        $profile->update([
            'approval_status'  => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify the driver
        Notification::create([
            'user_id' => $user->id,
            'title'   => '❌ Account Application Rejected',
            'message' => 'Your driver application was not approved. '
                         . 'Reason: ' . $request->rejection_reason
                         . ' Please contact support for assistance.',
            'type'    => 'account_rejected',
            'link'    => '/driver/profile',
        ]);

        AdminLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'reject_driver',
            'target_type' => 'user',
            'target_id'   => $user->id,
            'description' => 'Rejected driver: ' . $user->email
                             . ' — ' . $request->rejection_reason,
            'ip_address'  => request()->ip(),
        ]);

        return back()->with('success',
            $user->name . '\'s application has been rejected.');
    }
}