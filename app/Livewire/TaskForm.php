<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskForm extends Component
{
    public $taskId;
    public $title;
    public $description;

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
        }
    }

    public function save()
    {
        $this->validate();

        Task::updateOrCreate(['id' => $this->taskId], [
            'title' => $this->title,
            'description' => $this->description
        ]);

        $this->emit('taskSaved');
        $this->reset(['taskId', 'title', 'description']);
    }

    public function render()
    {
        return view('livewire.task-form');
    }
}
