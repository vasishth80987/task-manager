<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Task') }}
        </h2>
    </x-slot>
    @can('edit tasks')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @livewire('task-form', ['task' => $task])
            </div>
        </div>
    </div>
    @else
        <h1 class="display-4 text-center">Forbidden!</h1>
    @endcan
</x-app-layout>
