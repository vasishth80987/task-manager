<div>
    <h2>Tasks List</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->is_completed ? 'Completed' : 'Pending' }}</td>
                <td>
                    <button wire:click="edit({{ $task->id }})" class="btn btn-primary">Edit</button>
                    <button wire:click="delete({{ $task->id }})" class="btn btn-danger">Delete</button>
                    <button wire:click="toggleStatus({{ $task->id }})" class="btn btn-secondary">
                        {{ $task->is_completed ? 'Reopen' : 'Complete' }}
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No tasks found</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @livewire('task-form')
</div>

