<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return view('dashboard.galleries.index')->with('galleries',Gallery::orderby('id','desc')->get())->with('categories',Category::orderby('id','desc')->get());
    }
    public function create()
    {
        return view('dashboard.galleries.create')->with('categories',Category::orderby('id','desc')->get());
    }
    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'category_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Handle image upload
        $imagePath = $request->image->store('galleries');
        // Create gallery
        Gallery::create([
            'category_id' => $request->category_id,
            'image' => $imagePath, // Store image path
        ]);
        return redirect()->route('galleries.index')->with('toastr_success', 'تم حفظ الصورة بنجاح!');
    }
    public function edit(Gallery $gallery)
    {
        return view('dashboard.galleries.edit')->with(['gallery' => $gallery, 'categories' => Category::all()]);
    }
    public function update(Request $request, Gallery $gallery)
    {
        // Validate input fields
        $request->validate([
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Handle image upload
        if ($request->image) {
            $imagePath = $request->image->store('galleries');
        } else {
            $imagePath = $gallery->image; // Keep the old image
        }
        // Update gallery
        $gallery->update([
            'category_id' => $request->category_id,
            'image' => $imagePath, // Store image path
        ]);
        return redirect()->route('galleries.index')->with('toastr_success', 'تم تعديل الصورة بنجاح!');
    }
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('galleries.index')->with('toastr_success', 'تم حذف الصورة بنجاح!');
    }
}
