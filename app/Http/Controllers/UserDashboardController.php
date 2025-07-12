<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        return view('user_dashboard', compact('tasks'));
    }
}

