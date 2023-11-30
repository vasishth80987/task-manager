<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List of available Rest APis') }}
        </h2>
        Token: {{$token}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">API endpoint</th>
                <th scope="col">Description</th>
                <th scope="col">Methods</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td><a href="{{url('api/login')}}">api/login</a></td>
                <td>Login User and generate API Auth Token</td>
                <td>POST</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td><a href="{{url('api/tasks')}}">api/tasks</a></td>
                <td>View List of Tasks for user or create new task</td>
                <td>GET,POST</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td><a href="{{url('api/tasks/1')}}">api/tasks/{task}</a></td>
                <td>View/Update Task Details</td>
                <td>GET,PUT</td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td><a href="{{url('api/user')}}">api/user</a></td>
                <td>Get Logged in User Details</td>
                <td>GET</td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</x-app-layout>
