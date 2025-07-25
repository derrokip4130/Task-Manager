<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Mail\UserCreatedMail;
use App\Mail\UserUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $users = User::where('role', 'user')->get();
        return view('users', compact('users'));
    }

    public function dashboard()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $users = User::all();
        $tasks = Task::with('user')->get();
        return view('admin_dashboard', compact('users', 'tasks'));
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

        $tempPassword = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user',
            'password' => \Hash::make($tempPassword),
        ]);

        Mail::to($user->email)->send(new UserCreatedMail($user, $tempPassword));

        return redirect()->back()->with('user_success', 'User created and email sent.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        Mail::to($user->email)->send(new UserUpdatedMail($user->name, $user->email));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

}
