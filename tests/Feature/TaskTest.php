<?php

it('displays a list of tasks', function () {
    $user = \App\Models\User::factory()->create();

    $user->assigned->attach();
    actingAs($user)
        ->get(route('task.index'))
        ->assertStatus(200);
});
it('displays a specific task', function () {
    $user = \App\Models\User::factory()->create();
    $task = \App\Models\Task::factory()->create();

    actingAs($user)
        ->get(route('task.show', $task))
        ->assertStatus(200);
});
it('deletes a specific task', function () {
    $user = \App\Models\User::factory()->create();
    $task = \App\Models\Task::factory()->create();

    actingAs($user)
        ->delete(route('task.destroy', $task))
        ->assertStatus(302)
        ->assertSessionHasNoErrors();
});
it('prevents unauthorized access to create task', function () {
    $nonAdminUser = \App\Models\User::factory()->create();

    actingAs($nonAdminUser)
        ->post(route('task.store'), ['title' => 'Unauthorized Task'])
        ->assertStatus(403); // Forbidden status
});


