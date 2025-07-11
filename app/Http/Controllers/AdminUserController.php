<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $users = \App\Models\User::all();
        return view('admin_dashboard', compact('users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        $password = 'NewPassword123';

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user',
            'password' => \Hash::make($password),
        ]);

        // You can email them their password here if needed
        return redirect()->back()->with('success', 'User created.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        \App\Models\User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }

}
