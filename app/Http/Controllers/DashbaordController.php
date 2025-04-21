<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashbaordController extends Controller
{
    
    public function dashboard()
    {
        return view('dashboard.index');
    }
    public function setting()
    {
        return view('dashboard.setting');
    }
    public function add_general(Request $request)
    {
        // dd($request);
        if ($request->hasFile('general_file')) {
            foreach ($request->file('general_file') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value->store('general'));
            }
        }
        if ($request->has('general')) {

            foreach ($request->input('general') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value);
            }
        }

        return redirect()->back()->with(['success' => trans('Edit Successfuly')]);
    }
    public function edit_profile()
    {
        return view('dashboard.edit_profile');
    }
    public function edit_profile_post(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        if ($request->password != null) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => 'false'], 422);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        if ($request->image != null) {
            $user->image = $request->image->store('/users');
        }
        $user->save();
        return response()->json(['success' => 'true'], 200);
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    public function login()
    {
        if (auth()->check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }
    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        dd(get_general_value('admin_password'));
        if ($request->password === get_general_value('admin_password')) {
            $adminUser = User::where('role', 'admin')->first();
            
            if ($adminUser) {
                Auth::login($adminUser);
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with(['error' => trans('No admin user found')]);
            }
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['error' => trans('Email Or Password not correct')]);
    }

}
