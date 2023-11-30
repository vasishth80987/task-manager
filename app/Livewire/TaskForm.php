<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Task;
use Masmerise\Toaster\Toaster;

class TaskForm extends Component
{
    use AuthorizesRequests;

    // Public properties bound to the form fields
    public $task;
    public $taskId;
    public $title;
    public $description;
    public $completion;
    public $assignees;
    public $team_members;
    public $owner;
    public $owner_id;

    // Validation rules for task fields
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    /**
     * Mount component and Populate the component's properties
     *
     * @param Task|null $task The task to be edited, null if creating a new task.
     */
    public function mount(Task $task = null)
    {
        // Checks if an existing task is provided and initializes properties
        if ($task) {
            $this->task = $task;
            $this->authorize('view', $this->task);
            $this->taskId = $task->id;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->completion = $task->completion;
            $this->owner = $task->owner()->pluck('name');
            $this->owner_id = $task->owner()->pluck('id')->first();
            $this->assignees = $task->assignedTo()->pluck('user_id')->all();
            $this->team_members = collect();
            // Load team members for the task owner or the authenticated user if creating new task
            if($task->owner)
                foreach($task->owner->leads as $team){
                    $this->team_members = $this->team_members->merge($team->teamMembers->map(function (User $user) use ($team) {
                        $user->name .= '(Team: '.$team->id.')';
                        return $user;
                    }));
                }
            else
                foreach(auth()->user()->leads as $team){
                    $this->team_members = $this->team_members->merge($team->teamMembers->map(function (User $user) use ($team) {
                        $user->name .= '(Team: '.$team->id.')';
                        return $user;
                    }));
                }
            $this->team_members = $this->team_members->unique('id');
        }
    }

    public function save()
    {
        // Authorizes based on whether it's a new task or an existing one
        $this->authorize($this->task->id==null?'create':'update', $this->task);

        $this->validate(); // Validates input against defined rules
        $this->sanitize(); // Sanitizes input for security

        try{
            $create = !$this->owner_id; // Flag for new task creation
            if(!$this->owner_id){
                $create=true;
                $this->owner_id = auth()->id();
                $this->owner = auth()->user()->get('name');
            }

            // Handle task creation or updating
            $task = Task::updateOrCreate(['id' => $this->taskId], [
                'title' => $this->title,
                'description' => $this->description,
                'completion' => $this->completion ?? 0,
                'owner_id' => $this->owner_id
            ]);

            //update task assignees
            $new_assignees = array_diff($this->assignees,$task->assignedTo()->pluck('id')->toArray());
            $task->assignedTo()->sync($this->assignees);

            $this->dispatch('taskSaved');
            Toaster::success('Task Saved!');
            Log::channel('app')->notice('Updated Task:{id}', ['id' => $task->id]);

            // Notifies new assignees
            if(count($new_assignees)){
                Toaster::info('Notifications sent via email');
                Notification::send(User::find($new_assignees), new TaskAssigned($task));
            }
            if($create)
                redirect()->to('/task');
        }
        catch(\Exception $e){
            Log::debug('An error occurred while saving task. '.$e->getMessage());
            Toaster::error('Could not save Task! Check logs for more info.');
        }
    }

    /**
     * Toggles and updates the completion status of the task.
     */
    public function updateStatus(){
        $this->completion = !$this->completion;
        $this->task->completion = $this->completion;
        $this->task->save();
        Toaster::success('Status updated!');
    }

    /**
     * Sanitizes the input fields to prevent XSS attacks.
     */
    public function sanitize()
    {
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $this->description = filter_var($this->description, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    /**
     * Renders the TaskForm view.
     *
     * @return \Illuminate\View\View The view to be rendered.
     */
    public function render()
    {
        return view('livewire.task-form');
    }
}
