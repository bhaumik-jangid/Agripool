<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\TransportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PoolMatchingService;
use App\Http\Requests\StoreTransportRequestRequest;
use App\Http\Requests\UpdateTransportRequestRequest;

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
    public function store(StoreTransportRequestRequest $request)
    {
        // $request is already validated — no manual validate() needed
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $transportRequest = TransportRequest::create($validated);

        $matchingService = new PoolMatchingService();
        $matchingPool = $matchingService->findMatch($transportRequest);

        if ($matchingPool) {
            $costInfo = $matchingService->calculateSharedCost(
                $matchingPool,
                $transportRequest->quantity_kg
            );

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

            return redirect()->route('farmer.requests.confirm');
        }

        $matchingService->createNewPool($transportRequest);

        return redirect()->route('farmer.requests.index')
            ->with(
                'success',
                'Request submitted! A new pool has been created.'
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
    public function update(
        UpdateTransportRequestRequest $request,
        TransportRequest $transportRequest
    ) {
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$transportRequest->isEditable()) {
            return redirect()->route('farmer.requests.index')
                ->with(
                    'error',
                    'This request cannot be edited.'
                );
        }

        $transportRequest->update($request->validated());

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

    // Re-trigger auto matching for a pending request
    public function autoPool(Request $request)
    {
        $request->validate([
            'request_id' => ['required', 'exists:transport_requests,id'],
        ]);

        $transportRequest = TransportRequest::findOrFail($request->request_id);

        if ($transportRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transportRequest->status !== 'pending') {
            return back()->with(
                'error',
                'Only pending requests can be auto-matched.'
            );
        }

        $matchingService = new PoolMatchingService();
        $matchingPool = $matchingService->findMatch($transportRequest);

        if ($matchingPool) {
            $costInfo = $matchingService->calculateSharedCost(
                $matchingPool,
                $transportRequest->quantity_kg
            );

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

            return redirect()->route('farmer.requests.confirm');
        }

        // No match — create a new pool
        $matchingService->createNewPool($transportRequest);

        return redirect()->route('farmer.requests.index')
            ->with(
                'success',
                'A new pool has been created for your request!'
            );
    }

    public function pay(Request $request, TransportRequest $transportRequest)
    {
        if ($transportRequest->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => ['required', 'string'],
        ]);

        $poolMember = $transportRequest->poolMember;

        if (!$poolMember) {
            return back()->with('error', 'No pool membership found.');
        }

        $poolMember->update([
            'cost_paid' => true,
            'payment_method' => $request->payment_method,
        ]);

        // Update driver's earning record to paid
        if ($poolMember->pool && $poolMember->pool->shipment) {
            \App\Models\Earning::where(
                'shipment_id',
                $poolMember->pool->shipment->id
            )->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
        }

        return back()->with(
            'success',
            '✅ Payment of ₹'
            . number_format($poolMember->cost_share, 2)
            . ' confirmed via ' . $request->payment_method . '!'
        );
    }
}