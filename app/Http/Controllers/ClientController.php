<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.clients.index')->with('clients', Client::orderby('id', 'desc')->get())->with('packages', Package::where('status', 1)->get());
    }
    public function getActiveClients()
    {
        // الطريقة الأولى باستخدام scope
        $activeClients = Client::withActiveSubscription()
            ->with(['activeSubscription' => function ($query) {
                $query->with('package');
            }])
            ->orderBy('id', 'desc')->get();
        $activeClients = Client::getActiveSubscribers();

        return view('dashboard.clients.index')->with('clients', $activeClients)->with('packages', Package::where('status', 1)->get());
    }
    
    public function getNotActiveSubscribers()
    {
        $inactiveClients = Client::inactive()
        ->with(['subscriptions' => function($q) {
            $q->latest()->first();
        }])->orderBy('id', 'desc')->get();

        return view('dashboard.clients.index')->with('clients', $inactiveClients)->with('packages', Package::where('status', 1)->get());
    }
    public function getOrderData(Order $order)
    {
        return response()->json([
            'full_name' => $order->full_name,
            'phone' => $order->phone,
            'package' => [
                'name' => $order->package->name ?? null,
                'price' => $order->package->price ?? null
            ]
        ]);
    }
    public function store_sub(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date',
            'payment_method' => 'required|in:full,installments',
            'package_visit' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0'
        ]);

        $package = Package::find($validated['package_id']);
        $startDate = Carbon::parse($validated['start_date']);

        // حساب تاريخ الانتهاء
        $duration = (int)$package->number_date;
        $duration_type = $package->type_date;

        switch ($duration_type) {
            case 'day':
                $end_at = $startDate->addDays($duration);
                break;
            case 'week':
                $end_at = $startDate->addWeeks($duration);
                break;
            case 'month':
                $end_at = $startDate->addMonths($duration);
                break;
            case 'year':
                $end_at = $startDate->addYears($duration);
                break;
            default:
                $end_at = $startDate;
        }

        $subscription = Subscription::create([
            'client_id' => $validated['client_id'],
            'package_id' => $validated['package_id'],
            'payment_method' => $validated['payment_method'],
            'start_at' => $validated['start_date'],
            'end_at' => $end_at,
            'total_visit' => 0,
            'package_visit' => $validated['package_visit'],
            'total_amount' => $validated['total_amount'],
            'paid_amount' => $validated['paid_amount'],
            'added_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة الباقة بنجاح',
            'subscription_id' => $subscription->id
        ]);
    }

    public function calculateEndDate(Package $package, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        try {
            $duration = (int)$package->number_date;
            $durationType = $package->type_date;
            $startDate = Carbon::parse($request->start_date);

            $endDate = match ($durationType) {
                'day'   => $startDate->addDays($duration),
                'week'  => $startDate->addWeeks($duration),
                'month' => $startDate->addMonths($duration),
                'year'  => $startDate->addYears($duration),
                default => $startDate,
            };

            return response()->json([
                'success'    => true,
                'end_date'   => $endDate->format('Y-m-d'),
                'duration'   => $this->getDurationText($duration, $durationType),
                'start_date' => $startDate->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to calculate end date: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حساب تاريخ الانتهاء'
            ], 500);
        }
    }

    private function getDurationText($duration, $type)
    {
        $types = [
            'day'   => ['يوم', 'أيام'],
            'week'  => ['أسبوع', 'أسابيع'],
            'month' => ['شهر', 'أشهر'],
            'year'  => ['سنة', 'سنوات'],
        ];

        $type = $types[$type] ?? [$type, $type];
        return $duration . ' ' . ($duration > 1 ? $type[1] : $type[0]);
    }
    public function storeFromOrder(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:clients,phone',
            'address' => 'nullable|string',
            'add_subscription' => 'nullable|in:true,false,1,0,on,off',
            'package_id' => 'required_if:add_subscription,1|exists:packages,id',
            'start_date' => 'required_if:add_subscription,1|date',
            'payment_method' => 'required_if:add_subscription,1|in:full,installments',
            'package_visit' => 'required_if:add_subscription,1|integer|min:1',
            'total_amount' => 'required_if:add_subscription,1|numeric|min:0',
            'paid_amount' => 'required_if:add_subscription,1|numeric|min:0'
        ]);

        // إنشاء العميل
        $client = Client::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'added_by' => auth()->id(),
            'id_number' => rand(1000000000, 9999999999)
        ]);


        // إنشاء الاشتراك إذا طُلب
        if ($request->add_subscription) {
            $package = Package::find($validated['package_id']);

            // حساب تاريخ الانتهاء
            $duration = (int)$package->number_date;
            $duration_type = $package->type_date;
            $startDate = Carbon::parse($validated['start_date']);

            switch ($duration_type) {
                case 'day':
                    $end_at = $startDate->addDays($duration);
                    break;
                case 'week':
                    $end_at = $startDate->addWeeks($duration);
                    break;
                case 'month':
                    $end_at = $startDate->addMonths($duration);
                    break;
                case 'year':
                    $end_at = $startDate->addYears($duration);
                    break;
                default:
                    $end_at = $startDate;
            }

            $subscription = Subscription::create([
                'client_id' => $client->id,
                'package_id' => $validated['package_id'],
                'payment_method' => $validated['payment_method'],
                'start_at' => $validated['start_date'],
                'end_at' => $end_at,
                'total_visit' => 0,
                'package_visit' => $validated['package_visit'],
                'total_amount' => $validated['total_amount'],
                'paid_amount' => $validated['paid_amount'],
                'added_by' => auth()->id()
            ]);
        }
        $qrCodePath = "uploads/qrcodes/client_{$client->id}.svg";
        $clientUrl = route('clients.show', $client->id);

        // توليد رمز QR وحفظه كصورة PNG
        QrCode::format('svg')->size(300)->generate($clientUrl, public_path($qrCodePath));
        $client->update(['qr_code' => $qrCodePath]);


        return response()->json([
            'success' => true,
            'message' => 'تم إضافة العميل بنجاح وربطه بالطلب'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create')->with('packages', Package::where('status', 1)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:clients,phone',
            'address' => 'required'
        ]);
        $request_all = $request->all();
        $request_all['id_number'] = rand(1000000000, 9999999999);
        $request_all['added_by'] = auth()->id();
        $qrCodeDir = public_path('uploads/qrcodes');
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        // تحديد مسار حفظ الصورة


        $client =  Client::create($request_all);
        $qrCodePath = "uploads/qrcodes/client_{$client->id}.svg";
        $clientUrl = route('clients.show', $client->id);

        // توليد رمز QR وحفظه كصورة PNG
        QrCode::format('svg')->size(300)->generate($clientUrl, public_path($qrCodePath));
        $client->update(['qr_code' => $qrCodePath]);

        return response()->json([
            'message' => 'تم إنشاء العميل بنجاح!',
            'client_id' => $client->id, // ✅ تأكد من إرجاع client_id
        ]);
    }

    /**
     * Check if the phone number exists for any client.
     */
    public function checkPhoneNumber(Request $request)
    {
        $phone = $request->input('phone');
        $exists = Client::where('phone', $phone)->exists();

        return response()->json(['exists' => $exists]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('dashboard.clients.show')->with('client', $client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit')->with('client', $client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:clients,phone,' . $client->id,
            'address' => 'required'
        ]);
        $client->update($request->all());
        return redirect()->route('clients.index')->with('toastr_success', 'تم تعديل العميل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('toastr_success', 'تم حذف العميل بنجاح');
    }
}
