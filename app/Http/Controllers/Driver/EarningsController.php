<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use Illuminate\Support\Facades\Auth;

class EarningsController extends Controller
{
    public function index()
    {
        $earnings = Earning::where('user_id', Auth::id())
                       ->with('shipment.pool')
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        $totalPaid    = Earning::where('user_id', Auth::id())
                               ->where('status', 'paid')->sum('amount');
        $totalPending = Earning::where('user_id', Auth::id())
                               ->where('status', 'pending')->sum('amount');

        return view('driver.earnings.index', compact(
            'earnings', 'totalPaid', 'totalPending'
        ));
    }
}