<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|int'
        ]);

        $task = Task::create($validatedData);
        return response()->json($task, Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        return response()->json($task, Response::HTTP_OK);
    }

    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|int'
        ]);

        $task->update($validatedData);
        return response()->json($task, Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
