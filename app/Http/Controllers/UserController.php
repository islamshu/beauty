<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.users.index')->with('users', User::orderby('id', 'desc')->get());
    }
    public function create()
    {
        return view('dashboard.users.create')->with('roles', Role::all());
    }
    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Handle image upload
        if ($request->image) {
            $imagePath = $request->image->store('uploads/users');
        } else {
            $imagePath = 'users/default.png'; // Default image
        }
        // Create user
        $user =   User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image' => $imagePath, // Store image path
        ]);
        $user->assignRole($request->role); // Assign the 'admin' role
        return redirect()->route('users.index')->with('toastr_success', 'تم حفظ المستخدم بنجاح!');
    }
    public function edit(User $user)
    {
        return view('dashboard.users.edit')->with(['user' => $user, 'roles' => Role::all()]);
    }
    public function update(Request $request, User $user)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/users');
            $user->image = $imagePath;
        }

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password, // Keep old password if not changed
        ]);
        $user->syncRoles([$request->role]); 

        return redirect()->back()->with('toastr_success', 'تم تحديث المستخدم بنجاح!');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('toastr_success', 'تم حذف المستخدم بنجاح!');
    }
}
