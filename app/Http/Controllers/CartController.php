<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem ;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // عرض محتويات السلة
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        return view('frontend.cart', compact('cart', 'total'));
    }

    // إضافة منتج إلى السلة
    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->title,
                "product_id" => $product->id,

                "quantity" => 1,
                "price" => $product->price_after_discount,
                "image" => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'تمت إضافة المنتج إلى السلة بنجاح.');
    }

    // تحديث كمية المنتج
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'total' => $this->calculateTotal($cart), // إرجاع الإجمالي المحدث
        ]);
    }

    // حذف منتج من السلة
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'تم حذف المنتج من السلة بنجاح.');
    }

    // حساب الإجمالي
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'السلة فارغة.']);
        }

    
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    
        // إنشاء الطلب
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'customer_id' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'customer_address' => 'required|string|max:500',
        ], [
            'customer_name.required' => 'الرجاء إدخال الاسم الكامل.',
            'customer_phone.required' => 'الرجاء إدخال رقم الهاتف.',
            'customer_phone.regex' => 'الرجاء إدخال رقم هاتف صالح.',
            'customer_id.regex' => 'الرجاء إدخال رقم هوية صالح.',

            'customer_address.required' => 'الرجاء إدخال عنوان التوصيل.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(), // إرجاع أول خطأ فقط
            ], 422);
        }

        // ✅ حساب السعر الإجمالي
        $cart = session()->get('cart', []);
        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        // ✅ إنشاء الطلب
        $order = CustomerOrder::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_id' => $request->customer_id,
            'customer_address' => $request->customer_address,
            'total_price' => $totalPrice,
        ]);
    
        // إضافة المنتجات إلى الطلب
        foreach ($cart as $item) {
           CustomerOrderItem::create([
                'customer_order_id' => $order->id,
                'product_name' => $item['name'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    
        session()->forget('cart'); // مسح السلة بعد الطلب
    
        return response()->json([
            'success' => true,
            'message' => 'تم إتمام الطلب بنجاح!',
        ]);  
      }
}
