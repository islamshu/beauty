<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Subscription;
use App\Models\Visit;
use App\Models\User;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function __construct()
    {
        // This will make $supervisors available in all views that extend this controller
        $supervisors = User::all();
        view()->share('supervisors', $supervisors);
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'subscription_id' => 'required|exists:subscriptions,id',
            'package_id' => 'required|exists:packages,id',
            'visit_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);
    
        $subscription = Subscription::findOrFail($request->subscription_id);

        // Verify the package matches the subscription's package
        if ($subscription->package_id != $request->package_id) {
            return response()->json([
                'message' => 'الباقة المحددة لا تطابق باقة الاشتراك'
            ], 422);
        }
    
        // Check if subscription is active and has remaining visits
        if (!$subscription->isActive()) {
            return response()->json([
                'message' => 'لا يمكن إضافة زيارة لاشتراك منتهي'
            ], 422);
        }
    
        if ($subscription->total_visit >= $subscription->package_visit) {
            return response()->json([
                'message' => 'تم استهلاك جميع زيارات الباقة'
            ], 422);
        }
    
        // Create visit
        $visit = Visit::create($validated);
    
        // Increment subscription visits
        $subscription->increment('total_visit');
    
        return response()->json([
            'success' => true,
            'visit' => $visit->load(['package', 'supervisor'])
        ]);
    }

    // ... keep your other methods ...
}
