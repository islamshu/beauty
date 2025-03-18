<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
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

}
