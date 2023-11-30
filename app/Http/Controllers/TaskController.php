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
use Masmerise\Toaster\Toast;
use Masmerise\Toaster\Toastable;

class TaskController extends Controller
{
    use Toastable;

    /**
     * Constructor to add middleware for role-based permissions.
     */
    public function __construct()
    {
        // Applying permissions middleware to respective methods
        $this->middleware('permission:view tasks')->only(['index', 'show']);
        $this->middleware('permission:create tasks')->only(['create', 'store']);
        $this->middleware('permission:edit tasks')->only(['edit', 'update']);
        $this->middleware('permission:delete tasks')->only('destroy');
    }

    /**
     * Display a listing of tasks.
     *
     * @param TaskDataTable $dataTable
     * @return \Illuminate\View\View
     */
    public function index(TaskDataTable $dataTable)
    {
        // Admins can see all tasks; other users see only their tasks
        if (auth()->user()->hasRole('admin')) {
            $tasks = Task::all()->pluck('id')->toArray();
        } else {
            $tasks = auth()->user()->owns->pluck('id')->merge(auth()->user()->assigned->pluck('id'))->toArray();
        }

        // Set query for DataTable and render the index view
        $dataTable->setQuery($tasks);
        return $dataTable->render('task.index');
    }

    /**
     * Show the form for creating a new task.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        // Authorization check for task creation
        $this->authorize('create', Task::class);

        $task = new Task();
        return view('task.create', compact('task'));
    }

    /**
     * Store a newly created task in the database.
     *
     * @param TaskStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskStoreRequest $request): RedirectResponse
    {
        // Authorization check for storing new task
        $this->authorize('create', Task::class);

        // Create task with validated data from the request
        $task = Task::create($request->validated());

        // Flash task ID to session
        $request->session()->flash('task.id', $task->id);

        // Redirect to task index route
        return redirect()->route('task.index');
    }

    /**
     * Display the specified task.
     *
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Task $task): View
    {
        // Authorization check for viewing a task
        $this->authorize(['view', 'viewAny'], Task::class);

        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Task $task): View
    {
        // Authorization check for editing a task
        $this->authorize('view', $task);
        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified task in the database.
     *
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        // Authorization check for updating a task
        $this->authorize('update', $task);

        // Update task with validated data from the request
        $task->update($request->validated());

        // Flash task ID to session
        $request->session()->flash('task.id', $task->id);

        // Redirect to task index route
        return redirect()->route('task.index');
    }

    /**
     * Remove the specified task from the database.
     *
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        // Authorization check for deleting a task
        $this->authorize('delete', $task);

        try {
            // Attempt to delete the task
            $task->delete();
            // On successful deletion, log and show success message
            $this->success('Task Deleted');
            Log::channel('app')->notice('Deleted Task:{id}', ['id' => $task->id]);
            // Redirect to task index route
            return redirect()->route('task.index');
        } catch (\Exception $e) {
            // Log any exceptions during deletion and show error message
            Log::debug('An error occurred while deleting task. '.$e->getMessage());
            $this->error('Error deleting task');
            // Redirect to task index route
            return redirect()->route('task.index');
        }
    }
}
