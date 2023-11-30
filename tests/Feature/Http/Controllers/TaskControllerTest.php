<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TaskController
 */
final class TaskControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get(route('task.index'));

        $response->assertOk();
        $response->assertViewIs('task.index');
        $response->assertViewHas('tasks');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('task.create'));

        $response->assertOk();
        $response->assertViewIs('task.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'store',
            \App\Http\Requests\TaskStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $completion = $this->faker->boolean();
        $owner = App\Models\User::factory()->create();

        $response = $this->post(route('task.store'), [
            'title' => $title,
            'description' => $description,
            'completion' => $completion,
            'owner_id' => $owner->id,
        ]);

        $tasks = Task::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('completion', $completion)
            ->where('owner_id', $owner->id)
            ->get();
        $this->assertCount(1, $tasks);
        $task = $tasks->first();

        $response->assertRedirect(route('task.index'));
        $response->assertSessionHas('task.id', $task->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('task.show', $task));

        $response->assertOk();
        $response->assertViewIs('task.show');
        $response->assertViewHas('task');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('task.edit', $task));

        $response->assertOk();
        $response->assertViewIs('task.edit');
        $response->assertViewHas('task');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'update',
            \App\Http\Requests\TaskUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $task = Task::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $completion = $this->faker->boolean();
        $owner = App\Models\User::factory()->create();

        $response = $this->put(route('task.update', $task), [
            'title' => $title,
            'description' => $description,
            'completion' => $completion,
            'owner_id' => $owner->id,
        ]);

        $task->refresh();

        $response->assertRedirect(route('task.index'));
        $response->assertSessionHas('task.id', $task->id);

        $this->assertEquals($title, $task->title);
        $this->assertEquals($description, $task->description);
        $this->assertEquals($completion, $task->completion);
        $this->assertEquals($owner->id, $task->owner_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('task.destroy', $task));

        $response->assertRedirect(route('task.index'));

        $this->assertModelMissing($task);
    }
}
