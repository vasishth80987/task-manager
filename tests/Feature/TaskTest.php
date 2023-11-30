<?php
use function Pest\Laravel\{actingAs};
it('display a list of tasks for admin', function () {
    $this->artisan('db:seed');
    $user = \App\Models\User::factory()->create();

    actingAs($user)
        ->get(route('task.index'))
        ->assertStatus(200);
});
it('displays a specific task', function () {
    $this->artisan('db:seed');
    $user = \App\Models\User::factory()->create()->assignRole('user');
    $task = \App\Models\Task::factory()->create();

    actingAs($user)
        ->get(route('task.show', $task))
        ->assertStatus(200);
});
it('deletes a specific task', function () {
    $this->artisan('db:seed');

    $user = \App\Models\User::factory()->create()->assignRole('manager');
    $task = \App\Models\Task::factory()->create();

    actingAs($user)
        ->delete(route('task.destroy', $task))
        ->assertStatus(302)
        ->assertSessionHasNoErrors();
});
it('prevents unauthorized access to create task', function () {
    $this->artisan('db:seed');
    $nonAdminUser = \App\Models\User::factory()->create();
    $nonAdminUser->assignRole('user');
    actingAs($nonAdminUser)
        ->post(route('task.store'), ['title' => 'Unauthorized Task'])
        ->assertStatus(403); // Forbidden status
});


