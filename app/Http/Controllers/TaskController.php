<?php

namespace App\Http\Controllers;

use App\DataTables\TaskDataTable;
use App\Http\Requests\TaskSaveRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Masmerise\Toaster\Toast;
use Masmerise\Toaster\Toastable;

class TaskController extends Controller
{
    use Toastable;

    public function index(TaskDataTable $dataTable)
    {
        return $dataTable->render('task.index');
    }

    public function create(Request $request): View
    {
        $task = new Task();
        return view('task.create',compact('task'));
    }

    public function edit(Request $request, Task $task): View
    {
        return view('task.edit', compact('task'));
    }

    public function save(TaskSaveRequest $request, Task $task): RedirectResponse
    {
        $task->save();

        return redirect()->route('task.show', ['task' => $task]);
    }

    public function show(Request $request, Task $task): View
    {
        return view('task.show', compact('task'));
    }

    public function destroy(Task $task)
    {
        // Optional: Check if the user is authorized to delete the task
        // $this->authorize('delete', $task);

        try {
            $task->delete();
            $this->success('Task Deleted');
            return redirect()->route('task.index')
                ->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception if the task can't be deleted
            // Log the error or handle it as needed
            return redirect()->route('task.index')
                ->with('error', 'Error deleting task');
        }
    }
}
