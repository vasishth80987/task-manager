<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskSaveRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = Task::all();

        return view('task.index', compact('tasks'));
    }

    public function create(Request $request): View
    {
        $user = User::find($id);

        return view('task.create', compact('user'));
    }

    public function edit(Request $request, Task $task): View
    {
        return view('task.edit', compact('task'));
    }

    public function save(TaskSaveRequest $request): RedirectResponse
    {
        $task->save();

        return redirect()->route('task.show', ['task' => $task]);
    }

    public function show(Request $request, Task $task): View
    {
        return view('task.show', compact('task'));
    }
}
