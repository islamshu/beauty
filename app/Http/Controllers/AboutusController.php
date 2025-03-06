<?php

namespace App\Http\Controllers;

use App\Models\Aboutus;
use Illuminate\Http\Request;

class AboutusController extends Controller
{
    public function index(){
        return view('dashboard.aboutus.index')->with('about', Aboutus::first());
    }
    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required',
            'descritpion' => 'required',
        ]);
    
        // Prepare the data for update or create
        $request_all = $request->except('image');
    
        // Handle image upload if present
        if ($request->image) {
            $request->validate([
                'image' => 'required',
            ]);
            $request_all['image'] = $request->image->store('aboutus');
        }
    
        // Use updateOrCreate to update or create the record
        $about = Aboutus::updateOrCreate(
            ['id' => 1], // Conditions to find the record
            $request_all // Data to update or create
        );
    
        // Redirect back with a success message
        return redirect()->back()->with('toastr_successg', 'تم التعديل بنجاح');
    }
    
}
