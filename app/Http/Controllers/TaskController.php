<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use App\Models\User;


class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'required|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'deadline' => $request->deadline,
            'status' => 'Pending', // default
        ]);

        return redirect()->back()->with('success', 'Task assigned successfully!');
    }
}
