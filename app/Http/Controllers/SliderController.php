<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.sliders.index', [
            'sliders' => Slider::orderby('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_title' => 'nullable|string',
            'secand_title' => 'nullable|string',
            'image' => 'required|file',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
        ]);
        $request_all = $request->except('image');
        $request_all['image'] = $request->file('image')->store('sliders');
        Slider::create($request_all);

        return redirect()->route('sliders.index')->with('toastr_success', 'تم انشاء السلايدر بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('dashboard.sliders.edit', [
            'slider' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'first_title' => 'nullable|string',
            'secand_title' => 'nullable|string',
            'image' => 'nullable|file',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
        ]);
        $request_all = $request->except('image');
        if ($request->hasFile('image')) {
            $request_all['image'] = $request->file('image')->store('sliders');
        }
        $slider->update($request_all);
        return redirect()->route('sliders.index')->with('toastr_success', 'تم تعديل السلايدر بنجاح!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function update_status_slider(Request $request){
        $slider = Slider::find($request->slider_id);
        $slider->status = $request->status;
        $slider->save();
        return response()->json(['status' => 'success']);
    }
    public function destroy(Slider $slider)
    {
        $slider->delete();  
        return redirect()->route('sliders.index')->with('toastr_success', 'تم حذف السلايدر بنجاح!');
    }
}
