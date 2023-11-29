<?php

use App\Livewire\TaskForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TaskForm::class)
        ->assertStatus(200);
});
