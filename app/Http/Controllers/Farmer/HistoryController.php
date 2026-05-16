<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\TransportRequest;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Get all delivered or cancelled requests for this farmer
        $history = TransportRequest::where('user_id', Auth::id())
                       ->whereIn('status', ['delivered', 'cancelled'])
                       ->with('poolMember.pool.shipment') // eager load relationships
                       ->orderBy('updated_at', 'desc')
                       ->paginate(10);

        return view('farmer.history', compact('history'));
    }
}