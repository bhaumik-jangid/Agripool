<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;

class FeedbackManagementController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user', 'shipment')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        $counts = [
            'open'     => Feedback::where('status', 'open')->count(),
            'reviewed' => Feedback::where('status', 'reviewed')->count(),
            'resolved' => Feedback::where('status', 'resolved')->count(),
        ];

        return view('admin.feedback.index', compact('feedbacks', 'counts'));
    }

    public function resolve(Feedback $feedback)
    {
        $feedback->update(['status' => 'resolved']);

        AdminLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'resolve_feedback',
            'target_type' => 'feedback',
            'target_id'   => $feedback->id,
            'description' => 'Resolved feedback #' . $feedback->id,
            'ip_address'  => request()->ip(),
        ]);

        return back()->with('success', 'Feedback marked as resolved.');
    }
}