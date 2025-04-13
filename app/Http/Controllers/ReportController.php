<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function payments(Request $request)
    {
        $query = SubscriptionPayment::with(['subscription.package', 'subscription.client'])
            ->orderBy('id', 'desc');

        // if($request->has('package_id') {
        //     $query->whereHas('subscription.package', function($q) use ($request) {
        //         $q->where('id', $request->package_id);
        //     });
        // }
        if ($request->has('package_id') && $request->package_id != null) {
            $query->whereHas('subscription.package', function ($q) use ($request) {
                $q->where('id', $request->package_id);
            });
        }
        if ($request->has('client_id') && $request->client_id != null) {
            $query->whereHas('subscription.client', function ($q) use ($request) {
                $q->where('id', $request->client_id);
            });
        }

        // فلترة حسب التاريخ
        if ($request->has('start_date') && $request->start_date != null) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != null) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $subs = $query->get();
        $packages = Package::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر
        $clients = Client::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر

        return view('dashboard.reports.payments', compact('subs', 'packages', 'clients'));
    }

    public function subscription(Request $request)
    {
        $query = Subscription::with(['package', 'client'])
            ->orderBy('id', 'desc');
        if ($request->has('package_id') && $request->package_id != null) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('id', $request->package_id);
            });
        }
        if ($request->has('client_id') && $request->client_id != null) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('id', $request->client_id);
            });
        }

        // فلترة حسب التاريخ
        if ($request->has('start_date') && $request->start_date != null) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != null) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $subscriptions = $query->get();
        $packages = Package::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر
        $clients = Client::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر

        return view('dashboard.reports.subscription', compact('subscriptions', 'packages', 'clients'));
    }
    public function visits(Request $request)
    {
        $query = Visit::with(['package', 'client','supervisor'])
            ->orderBy('id', 'desc');
        if ($request->has('package_id') && $request->package_id != null) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('id', $request->package_id);
            });
        }
        if ($request->has('client_id') && $request->client_id != null) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('id', $request->client_id);
            });
        }
     
      

        // فلترة حسب التاريخ
        if ($request->has('start_date') && $request->start_date != null) {
            $query->whereDate('visit_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != null) {
            $query->whereDate('visit_date', '<=', $request->end_date);
        }
        if ($request->has('supervisor') && $request->supervisor != null) {
            $query->whereHas('supervisor', function ($q) use ($request) {
                $q->where('id', $request->supervisor);
            });
        }
        $supervisorName = null;
        $supervisorVisitCount = null;

        if ($request->has('supervisor') && $request->supervisor != null) {
            $supervisor = User::find($request->supervisor);
            if ($supervisor) {
                $supervisorName = $supervisor->name;
                $supervisorVisitCount = $query->count(); // عدد زيارات المشرف ضمن التاريخ المحدد
            }
        }


        $vistis = $query->get();
        $packages = Package::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر
        $clients = Client::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر
        $users = User::all(); // نحتاج هذا لعرض قائمة الباقات في الفلتر

        return view('dashboard.reports.visits', compact('vistis', 'packages', 'clients', 'users', 'supervisorName', 'supervisorVisitCount'));
    }
    public function showSubscription(Subscription $subscription)
    {
        $subscription->load(['client', 'package', 'addedBy', 'payments', 'visits']);
        return view('dashboard.reports.subscriptionshow', compact('subscription'));
    }
}
