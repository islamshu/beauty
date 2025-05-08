<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
{
    $orders = CustomerOrder::latest()->paginate(10); // جلب جميع الطلبات مع الترتيب تنازليًا والتقسيم إلى صفحات
    return view('dashboard.productorders.index', compact('orders'));
}
public function show($id)
{
    $order = CustomerOrder::with('items')->find($id); // جلب الطلب مع العناصر الخاصة به
    return view('dashboard.productorders.show', compact('order'));
}
public function updateStatus(Request $request, CustomerOrder $order)
{
    $request->validate([
        'status' => 'required|in:جاري المتابعة,تم الارسال',
    ]);

    $order->status = $request->status;
    $order->save();

    return response()->json(['success' => true]);
}

public function fetchOrder($id)
{
    $order = Order::with('package')->findOrFail($id);

    return response()->json([
        'id' => $order->id,
        'phone' => $order->phone,
        'full_name' => $order->full_name,
        'package_name' => $order->package->name ?? 'تم حذف الباقة',
        'price' => $order->package->price ?? 0,
        'number_of_visits' => $order->package->number_of_visits ?? 0,
        'package_id' => $order->package->id ?? '',
        'country_code'=>$order->country_code,
        'phone_number'=>$order->phone_number,
        'address'=>$order->address
    ]);
}


}
