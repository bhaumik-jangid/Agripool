<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\TransportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PoolMatchingService;

class TransportRequestController extends Controller
{
    // ── INDEX — Show all requests by this farmer ──────────────
    // Like: GET /api/requests?userId=123 in Express
    public function index()
    {
        $requests = TransportRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 per page — like mongoose .limit()

        return view('farmer.requests.index', compact('requests'));
    }

    // ── CREATE — Show the create form ─────────────────────────
    public function create()
    {
        return view('farmer.requests.create');
    }

    // ── STORE — Save the new request to database ──────────────
    // Like: POST /api/requests in Express
    public function store(Request $request)
    {
        $validated = $request->validate([
            'crop_type' => ['required', 'string', 'max:100'],
            'quantity_kg' => ['required', 'numeric', 'min:1', 'max:50000'],
            'packaging_type' => ['required', 'string', 'max:100'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'pickup_district' => ['required', 'string', 'max:100'],
            'pickup_state' => ['required', 'string', 'max:100'],
            'destination_market' => ['required', 'string', 'max:255'],
            'destination_district' => ['required', 'string', 'max:100'],
            'preferred_pickup_date' => ['required', 'date', 'after:today'],
            'preferred_pickup_time' => ['nullable', 'string'],
            'special_instructions' => ['nullable', 'string', 'max:500'],
        ]);

        if (!empty($validated['preferred_pickup_time'])) {
            $validated['preferred_pickup_time'] = date(
                'H:i:s',
                strtotime($validated['preferred_pickup_time'])
            );
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $transportRequest = TransportRequest::create($validated);

        // Run matching service — only FIND, do not join yet
        $matchingService = new PoolMatchingService();
        $matchingPool = $matchingService->findMatch($transportRequest);

        if ($matchingPool) {
            // A pool match was found — calculate costs and show confirmation
            $costInfo = $matchingService->calculateSharedCost(
                $matchingPool,
                $transportRequest->quantity_kg
            );

            // Store match details in session for the confirmation page
            session([
                'pool_match' => [
                    'request_id' => $transportRequest->id,
                    'pool_id' => $matchingPool->id,
                    'pool_code' => $matchingPool->pool_code,
                    'destination' => $matchingPool->destination_market,
                    'pickup_date' => $matchingPool->pickup_date->format('d M Y'),
                    'farmers_count' => $matchingPool->members()->count(),
                    'shared_cost' => $costInfo['cost'],
                    'saving' => $costInfo['saving'],
                    'full_cost' => $matchingPool->total_cost,
                    'share_percent' => $costInfo['share_percent'],
                    'farmer_kg' => $transportRequest->quantity_kg,
                    'pool_used_kg' => $matchingPool->used_capacity_kg,
                ]
            ]);

            // Redirect to confirmation page
            return redirect()->route('farmer.requests.confirm');
        }

        // No match found — create new pool automatically, farmer is first member
        $matchingService->createNewPool($transportRequest);

        return redirect()->route('farmer.requests.index')
            ->with(
                'success',
                '✅ Request submitted! A new pool has been created. '
                . 'Other farmers going the same way will be added soon.'
            );
    }

    // Show the pool match confirmation page
    public function confirm()
    {
        // If no match data in session, redirect back
        if (!session('pool_match')) {
            return redirect()->route('farmer.requests.index');
        }

        $match = session('pool_match');
        return view('farmer.requests.confirm', compact('match'));
    }

    // Handle farmer's choice: join shared or go solo
    public function processConfirm(Request $request)
    {
        $request->validate([
            'choice' => ['required', 'in:shared,solo'],
            'request_id' => ['required', 'exists:transport_requests,id'],
            'pool_id' => ['required_if:choice,shared', 'exists:pools,id'],
        ]);

        $transportRequest = TransportRequest::findOrFail($request->request_id);

        // Security: make sure this request belongs to logged in farmer
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403);
        }

        $matchingService = new PoolMatchingService();

        if ($request->choice === 'shared') {
            $pool = \App\Models\Pool::findOrFail($request->pool_id);
            $matchingService->joinPool($pool, $transportRequest);
            $message = '🤝 You joined a shared pool! Your estimated cost is ₹'
                . number_format(session('pool_match.shared_cost'), 2);
        } else {
            $matchingService->goSolo($transportRequest);
            $message = '🚛 Solo transport booked! Full truck reserved for you.';
        }

        // Clear the session match data
        session()->forget('pool_match');

        return redirect()->route('farmer.requests.index')
            ->with('success', $message);
    }

    // ── SHOW — View a single request ──────────────────────────
    public function show(TransportRequest $transportRequest)
    {
        // Security: make sure this request belongs to the logged-in farmer
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('farmer.requests.show', compact('transportRequest'));
    }

    // ── EDIT — Show edit form ─────────────────────────────────
    public function edit(TransportRequest $transportRequest)
    {
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Only allow editing pending or pooled requests
        if (!$transportRequest->isEditable()) {
            return redirect()->route('farmer.requests.index')
                ->with('error', 'This request cannot be edited in its current status.');
        }

        return view('farmer.requests.edit', compact('transportRequest'));
    }

    // ── UPDATE — Save edited request ──────────────────────────
    public function update(Request $request, TransportRequest $transportRequest)
    {
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$transportRequest->isEditable()) {
            return redirect()->route('farmer.requests.index')
                ->with('error', 'This request cannot be edited.');
        }

        $validated = $request->validate([
            'crop_type' => ['required', 'string', 'max:100'],
            'quantity_kg' => ['required', 'numeric', 'min:1', 'max:50000'],
            'packaging_type' => ['required', 'string', 'max:100'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'pickup_district' => ['required', 'string', 'max:100'],
            'pickup_state' => ['required', 'string', 'max:100'],
            'destination_market' => ['required', 'string', 'max:255'],
            'destination_district' => ['required', 'string', 'max:100'],
            'preferred_pickup_date' => ['required', 'date'],
            'preferred_pickup_time' => ['nullable', 'string'],
            'special_instructions' => ['nullable', 'string', 'max:500'],
        ]);

        if (!empty($validated['preferred_pickup_time'])) {
            $validated['preferred_pickup_time'] = date(
                'H:i:s',
                strtotime($validated['preferred_pickup_time'])
            );
        }

        // Update — like findByIdAndUpdate in Mongoose
        $transportRequest->update($validated);

        return redirect()->route('farmer.requests.index')
            ->with('success', 'Request updated successfully!');
    }

    // ── DESTROY — Cancel/delete a request ─────────────────────
    public function destroy(TransportRequest $transportRequest)
    {
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$transportRequest->isEditable()) {
            return redirect()->route('farmer.requests.index')
                ->with('error', 'Only pending requests can be cancelled.');
        }

        // Soft cancel — change status instead of hard delete
        $transportRequest->update(['status' => 'cancelled']);

        return redirect()->route('farmer.requests.index')
            ->with('success', 'Request cancelled successfully.');
    }
}