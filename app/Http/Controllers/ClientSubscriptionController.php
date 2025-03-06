<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class ClientSubscriptionController extends Controller
{
    public function store(Request $request)
    {

        try {
            // التحقق من البيانات المدخلة
            $request->validate([
                'client_id' => 'required|exists:clients,id',
                'package' => 'required|exists:packages,id',
                'payment_method' => 'required|in:full,installments',
                'paid_amount' => 'nullable|numeric|min:0',
            ]);
            $package = Package::find($request->package);
            $duration = $package->number_date; // مثال: 10
            $duration_type = $package->type_date; // مثال: "day", "week", "month", "year"
            $duration = (int)$duration;
            // حساب تاريخ الانتهاء بناءً على نوع المدة
            switch ($duration_type) {
                case 'day':
                    $end_at = now()->addDays($duration);
                    break;
                case 'week':
                    $end_at = now()->addWeeks($duration);
                    break;
                case 'month':
                    $end_at = now()->addMonths($duration);
                    break;
                case 'year':
                    $end_at = now()->addYears($duration);
                    break;
                default:
                    $end_at = now(); // في حال لم يكن هناك مدة صحيحة
            }

            // إنشاء الاشتراك الجديد
            Subscription::create([
                'client_id' => $request->client_id,
                'package_id' => $request->package,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->payment_method === 'installments' ? $request->paid_amount : $package->price,
                'start_at' => now(),
                'end_at' => now()->addMonths(1),
                'total_visit' => 0,
                'package_visit' => $package->number_of_visits,
                'total_amount' => $package->price,
                'added_by' => auth()->id(),
            ]);

            return response()->json(['message' => 'تم إتمام الاشتراك بنجاح!']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء إتمام الاشتراك!'], 500);
        }
    }
}
