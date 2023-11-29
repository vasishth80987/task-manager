<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-4">
            @role('admin')
            <a href="/user" class="block hover:bg-gray-200 text-decoration-none">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Users") }}
                    </div>
                </div>
            </a>
            @endrole
            <a href="/task" class="block hover:bg-gray-200 text-decoration-none">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Tasks") }}
                    </div>
                </div>
            </a>
            <form action="/api/login" method="POST" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @csrf
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button type="submit">
                        {{ __("Access API") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
