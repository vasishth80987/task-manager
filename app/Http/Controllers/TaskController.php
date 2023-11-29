<?php

namespace App\Http\Controllers;

use App\DataTables\TaskDataTable;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(TaskDataTable $dataTable)
    {
        return $dataTable->render('task.index');
    }

    public function create(Request $request): View
    {
        return view('task.create');
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $task = Task::create($request->validated());

        $request->session()->flash('task.id', $task->id);

        return redirect()->route('task.index');
    }

    public function show(Request $request, Task $task): View
    {
        return view('task.show', compact('task'));
    }

    public function edit(Request $request, Task $task): View
    {
        return view('task.edit', compact('task'));
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        $request->session()->flash('task.id', $task->id);

        return redirect()->route('task.index');
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        try {
            $task->delete();
            $this->success('Task Deleted');
            Log::channel('app')->notice('Deleted Task:{id}', ['id' => $task->id]);
            return redirect()->route('task.index')
                ->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            Log::debug('An error occurred while deleting task. '.$e->getMessage());
            return redirect()->route('task.index')
                ->with('error', 'Error deleting task');
        }
    }
}
