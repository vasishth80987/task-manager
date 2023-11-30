<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>
    @can('view tasks')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <td>{{ $task->title }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $task->description }}</td>
                        </tr>
                        <tr>
                            <th>Completion</th>
                            <td>{{ $task->completion ? 'Completed' : 'Pending' }}</td>
                        </tr>
                        <tr>
                            <th>Assigned To</th>
                            <td>
                                @foreach ($task->assignedTo as $assignee)
                                    <span>{{ $assignee->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Created Date</th>
                            <td>{{ $task->created_at->format('Y-m-d') }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    @else
        <h1 class="display-4 text-center">Forbidden!</h1>
    @endcan
</x-app-layout>
