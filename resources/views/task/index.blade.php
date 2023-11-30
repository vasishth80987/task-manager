
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Showing Tasks For User: '.auth()->user()->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('create tasks')
                <a href="/task/create" class="btn btn-outline-success float-right">Create New Task</a>
            @endcan
            <div>
                {!! $dataTable->table(['class' => 'table table-bordered']) !!}
            </div>
        </div>
    </div>

    @push('scripts')
        {!! $dataTable->scripts() !!}
    @endpush
</x-app-layout>
