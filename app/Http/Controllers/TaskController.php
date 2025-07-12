<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use App\Models\User;
use App\Mail\TaskAssignedMail;

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

        Mail::to($task->user->email)->send(new TaskAssignedMail($task));

        return redirect()->back()->with('success', 'Task assigned successfully!');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task = Task::findOrFail($request->task_id);

        // Ensure user can only update their own tasks
        if (auth()->id() !== $task->user_id) {
            abort(403, 'Unauthorized to update this task.');
        }

        $task->status = $request->status;
        $task->save();

        return redirect()->back()->with([
            'success' => 'Task status updated successfully!',
            'updated_task_id' => $request->task_id
        ]);

    }
}
