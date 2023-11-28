<?php

// File: app/Http/Livewire/TasksList.php

namespace App\Livewire;

use PowerComponents\LivewirePowerGrid\{PowerGrid, PowerGridComponent, PowerGridEloquent};
use App\Models\Task;

class TasksList extends PowerGridComponent
{
    public function datasource(): ?string
    {
        return Task::class;
    }

    public function columns(): array
    {
        return [
            PowerGrid::column('id', 'ID')
                ->sortable()
                ->searchable(),

            PowerGrid::column('title', 'Title')
                ->sortable()
                ->searchable(),

            PowerGrid::column('description', 'Description')
                ->sortable()
                ->searchable(),

            PowerGrid::column('is_completed', 'Status')
                ->sortable()
                ->searchable()
                ->makeBoolean(['1' => 'Completed', '0' => 'Pending']),

            // Add more columns as needed
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('description')
            ->addColumn('is_completed');
    }

    // Add other necessary methods and properties

    public function render()
    {
        return view('livewire.tasks-list');
    }
}
