<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     *
     * If the authenticated user is an admin, they can see all tasks.
     * Otherwise, they see only tasks they own or are assigned to.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Check if the authenticated user is an admin
        if (auth('sanctum')->user()->hasRole('admin')) {
            // Fetch all tasks if user is admin
            $tasks = Task::all();
        } else {
            // Fetch tasks that the user owns or is assigned to if not an admin
            $tasks = auth('sanctum')->user()->owns->merge(auth()->user()->assigned);
        }

        // Return tasks as JSON response
        return response()->json($tasks, Response::HTTP_OK);
    }

    /**
     * Store a newly created task in storage.
     *
     * Only a user with the 'manager' role can create tasks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Check if the user has the 'manager' role
        if (!auth('sanctum')->user()->hasRole('manager')) {
            // Return forbidden response if user is not a manager
            return response()->json(['message' => 'Forbidden! Missing Role Permissions!'], 403);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|int'
        ]);

        // Create a new task with validated data
        $task = Task::create($validatedData);

        // Return the newly created task as JSON response
        return response()->json($task, Response::HTTP_CREATED);
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        // The authorization check is commented out, it can be used to restrict access
        // if (auth('sanctum')->user()->cannot('view', $task)) {
        //     return response()->json(['message' => 'Forbidden'], 403);
        // }

        // Return the task as JSON response
        return response()->json($task, Response::HTTP_OK);
    }

    /**
     * Update the specified task in storage.
     *
     * Only a user with the 'manager' role can update tasks.
     *
     * @param  \Illuminate\Http\Request  $requestç≈
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task)
    {
        // Check if the user has the 'manager' role
        if (!auth('sanctum')->user()->hasRole('manager')) {
            // Return forbidden response if user is not a manager
            return response()->json(['message' => 'Forbidden! Missing Role Permissions!'], 403);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|int'
        ]);

        // Update the task with validated data
        $task->update($validatedData);

        // Return the updated task as JSON response
        return response()->json($task, Response::HTTP_OK);
    }

    /**
     * Remove the specified task from storage.
     *
     * Only a user with the 'manager' role can delete tasks.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        // Check if the user has the 'manager' role
        if (!auth('sanctum')->user()->hasRole('manager')) {
            // Return forbidden response if user is not a manager
            return response()->json(['message' => 'Forbidden! Missing Role Permissions!'], 403);
        }

        // Delete the task
        $task->delete();

        // Return a no-content response
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
