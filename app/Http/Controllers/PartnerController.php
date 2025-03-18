<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return view('dashboard.partners.index')->with('partners',Partner::orderby('id','desc')->get())->with('categories',Category::orderby('id','desc')->get());
    }
    public function create()
    {
        return view('dashboard.partners.create')->with('categories',Category::orderby('id','desc')->get());
    }
    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Handle image upload
        $imagePath = $request->image->store('partners');
        // Create gallery
        Partner::create([
            'title' => $request->title,
            'image' => $imagePath, // Store image path
        ]);
        return redirect()->route('partners.index')->with('toastr_success', 'تم حفظ الصورة بنجاح!');
    }
    public function edit(Partner $gallery)
    {
        return view('dashboard.partners.edit')->with(['gallery' => $gallery, 'categories' => Category::all()]);
    }
    public function update(Request $request, Partner $gallery)
    {
        // Validate input fields
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Handle image upload
        if ($request->image) {
            $imagePath = $request->image->store('partners');
        } else {
            $imagePath = $gallery->image; // Keep the old image
        }
        // Update gallery
        $gallery->update([
            'title' => $request->title,
            'image' => $imagePath, // Store image path
        ]);
        return redirect()->route('partners.index')->with('toastr_success', 'تم تعديل الصورة بنجاح!');
    }
    public function destroy(Partner $gallery)
    {
        $gallery->delete();
        return redirect()->route('partners.index')->with('toastr_success', 'تم حذف الصورة بنجاح!');
    }
}
