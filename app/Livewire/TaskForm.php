<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Task;
use Masmerise\Toaster\Toaster;

class TaskForm extends Component
{
    public $taskId;
    public $title;
    public $description;
    public $completion;
    public $assignees;
    public $team_members;
    public $owner;
    public $owner_id;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string'
    ];

    public function mount(Task $task = null)
    {
        if ($task) {
            $this->taskId = $task->id;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->completion = $task->completion;
            $this->owner = $task->owner()->pluck('name');
            $this->owner_id = $task->owner()->pluck('id');
            $this->assignees = $task->assignedTo()->pluck('user_id')->all();
            $this->team_members = User::all(['id','name']);
        }
    }

    public function save()
    {
        $this->validate();

        if(!$this->owner_id->first()){
            $this->owner_id = auth()->id();
            $this->owner = auth()->user()->get('name');
        }

        $task = Task::updateOrCreate(['id' => $this->taskId], [
            'title' => $this->title,
            'description' => $this->description,
            'completion' => $this->completion ?? 0,
            'owner_id' => $this->owner_id->first()
        ]);

        $task->assignedTo()->sync($this->assignees);

        $this->dispatch('taskSaved');
        Toaster::success('Task Saved!');
    }

    public function render()
    {
        return view('livewire.task-form');
    }
}
