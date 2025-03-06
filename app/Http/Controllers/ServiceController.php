<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.services.index', [
            'services' => Service::orderby('id', 'desc')->get()
        ]);
    }
    public function update_status_service(Request $request)
    {
        $service = Service::find($request->service_id);
        $service->status = $request->status;
        $service->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.services.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'image'=>'required'
        ]);
        $request_all = $request->except('image');
        $request_all['image'] = $request->image->store('services');
        Service::create($request_all);
        return redirect()->route('services.index')->with('toastr_success', 'تم انشاء الخدمة بنجاح');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('dashboard.services.edit')->with('service', $service)->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        $request_all = $request->except('image');   
        if($request->image != null){
            $request_all['image'] = $request->image->store('services');
        }
        $service->update($request_all);
        return redirect()->route('services.index')->with('success', 'تم تعديل الخدمة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
