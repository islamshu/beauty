<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category')->get();
        return view('dashboard.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'nullable|string',
             'price' => 'required|numeric',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'category_id' => 'required|exists:categories,id',
             'show_price' => 'sometimes|boolean' // Add validation for the new field
         ]);
     
         $data = $request->all();
         
         // Set show_price value (default to true if not provided)
         $data['show_price'] = $request->has('show_price');
     
         if ($request->hasFile('image')) {
             $data['image'] = $request->image->store('images/courses');
         }
     
         Course::create($data);
     
         return redirect()->route('courses.index')->with('toastr_success', 'تم اضافة الدورة بنجاح!');
     }


    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('dashboard.courses.edit', compact('course', 'categories'));
    }

    public function show(Course $course)
    {
        $categories = Category::all();
        return view('dashboard.courses.show', compact('course', 'categories'));
    }
    public function updateStatus(Request $request)
    {
        $course = Course::find($request->course_id);
        $course->status = $request->status;
        $course->save();
        return response()->json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'show_price' => 'sometimes|boolean'
        ]);
    
        // Handle image upload and deletion
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image) {
                $imagePath = public_path('uploads/' . $course->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            // Store new image
            $validated['image'] = $request->image->store('images/courses');
        }
    
        // Ensure show_price is properly set (false when not checked)
        $validated['show_price'] = $request->has('show_price');
    
        $course->update($validated);
    
        return redirect()->route('courses.index')
            ->with('toastr_success', 'تم تعديل الدورة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('toastr_success', 'تم حذف الدورة بنجاح.');
    }
}
