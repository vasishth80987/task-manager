<?php

use App\Livewire\TaskForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TaskForm::class)
        ->assertStatus(200);
});
it('validates task form fields', function () {
    Livewire::test(\App\Livewire\TaskForm::class)
        ->set('title', '') // Empty title to trigger validation error
        ->set('description', 'Sample description')
        ->call('save')
        ->assertHasErrors(['title' => 'required']);
});
it('creates a task', function () {
    Livewire::actingAs($user)
        ->test(\App\Livewire\TaskForm::class)
        ->set('title', 'New Task')
        ->set('description', 'New Task Description')
        ->call('save')
        ->assertHasNoErrors()
        ->assertEmitted('taskSaved');
});
it('updates a task', function () {
    $task = \App\Models\Task::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\TaskForm::class, ['task' => $task])
        ->set('title', 'Updated Task Title')
        ->call('save')
        ->assertHasNoErrors()
        ->assertEmitted('taskSaved');
});
