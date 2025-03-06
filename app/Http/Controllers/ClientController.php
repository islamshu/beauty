<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Package;
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
        return view('dashboard.clients.index')->with('clients', Client::orderby('id', 'desc')->get());
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
