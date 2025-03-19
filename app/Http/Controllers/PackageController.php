<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(){
        return view('dashboard.packages.index')->with('packages', Package::orderby('id', 'desc')->get());
    }
    public function create(){
        return view('dashboard.packages.create')->with('services',Service::where('status',1)->get());
    }
    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file',
            'number_date' => 'required|string|max:255',
            'type_date' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            // 'description' => 'required|string|max:1000',
            'number_of_users_type' => 'required',
            'number_of_visits' => 'required|integer|min:1',
            'services' => 'required|array',
            'services.*' => 'exists:services,id'
        ]);
        if($request->number_of_users_type == 'limited'){
            $request->validate([
                'number_of_users' => 'required|integer|min:1',
            ]);
        }
        $request_all = $request->except(['image','services']);
        if($request->image != null){}
        $request_all['image']= $request->image->store('images/packages');
       $package= Package::create($request_all);
        $package->services()->attach($request->services);

        return redirect()->route('packages.index')->with('toastr_success','تم حفظ الباقة بنجاح!');
    }
    public function edit(Package $package){
        return view('dashboard.packages.edit')->with('package', $package)->with('services',Service::where('status',1)->get());
    }
    public function update_status_package(Request $request){
        $package = Package::find($request->package_id);
        $package->status = $request->status;
        $package->save();
        return response()->json(['status' => 'success']);
    }
    public function update(Request $request, Package $package){
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file',
            'number_date' => 'required|string|max:255',
            'type_date' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            // 'description' => 'required|string|max:1000',
            'number_of_users_type' => 'required',
            'number_of_visits' => 'required|integer|min:1',
            'services' => 'required|array',
            'services.*' => 'exists:services,id'
        ]);
        if($request->number_of_users_type == 'limited'){
            $request->validate([
                'number_of_users' => 'required|integer|min:1',
            ]);
        }
        $request_all = $request->except(['image','services']);
        if($request->image != null){
            $request_all['image']= $request->image->store('images/packages');
        }
        $package->update($request_all);
        $package->services()->sync($request->services);

        return redirect()->route('packages.index')->with('toastr_success','تم تعديل الباقة بنجاح!');
    }   

    public function destroy(Package $package){
        $package->delete();
        return redirect()->route('packages.index')->with('toastr_success','تم حذف الباقة بنجاح!');
    }
}
