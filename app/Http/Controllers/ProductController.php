<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderby('id','desc')->get();
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create')->with('categories',Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'title' => 'required|string|max:255',
            'price_after_discount' => 'required|numeric',
            'price_before_discount' => 'required|numeric',
            'small_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // رفع الصورة إلى المجلد المحدد
        $imagePath = $request->file('image')->store('products');

        // إنشاء المنتج
        Product::create([
            'title' => $request->title,
            'price_after_discount' => $request->price_after_discount,
            'price_before_discount' => $request->price_before_discount,
            'small_description' => $request->small_description,
            'long_description' => $request->long_description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('products.index')->with('toastr_success', 'تم إضافة المنتج بنجاح.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', compact('product'))->with('categories', Category::all());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Product $product)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'title' => 'required|string|max:255',
            'price_after_discount' => 'required|numeric',
            'price_before_discount' => 'required|numeric',
            'small_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // تحديث الصورة إذا تم تحميل صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            Storage::disk('public')->delete($product->image);
            // رفع الصورة الجديدة
            $imagePath = $request->file('image')->store('products');
        } else {
            $imagePath = $product->image;
        }
    
        // تحديث بيانات المنتج
        $product->update([
            'title' => $request->title,
            'price_after_discount' => $request->price_after_discount,
            'price_before_discount' => $request->price_before_discount,
            'small_description' => $request->small_description,
            'long_description' => $request->long_description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);
    
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('products.index')->with('toastr_success', 'تم تحديث المنتج بنجاح.');
    }
    public function update_status_product(Request $request)
    {
        // التحقق من وجود البيانات المطلوبة
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'status' => 'required|boolean',
        ]);

        // البحث عن المنتج باستخدام الـ ID
        $product = Product::findOrFail($request->product_id);

        // تحديث حالة المنتج
        $product->status = $request->status;
        $product->save();

        // إرجاع رسالة نجاح
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحالة بنجاح.',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('toastr_success', 'تم حذف المنتج بنجاح.');
    }
}
