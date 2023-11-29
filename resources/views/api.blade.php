<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List of available Rest APis') }}
        </h2>
        Token: {{$token->plainTextToken}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">API endpoint</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td><a href="{{url('api/tasks')}}">api/tasks</a></td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td><a href="{{url('api/task')}}">api/tasks</a></td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</x-app-layout>
