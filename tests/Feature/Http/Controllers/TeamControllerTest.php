<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TeamController
 */
final class TeamControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $teams = Team::factory()->count(3)->create();

        $response = $this->get(route('team.index'));

        $response->assertOk();
        $response->assertViewIs('team.index');
        $response->assertViewHas('teams');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('team.create'));

        $response->assertOk();
        $response->assertViewIs('team.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TeamController::class,
            'store',
            \App\Http\Requests\TeamStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user:team_lead = App\Models\User::factory()->create();

        $response = $this->post(route('team.store'), [
            'user:team_lead_id' => $user:team_lead->id,
        ]);

        $teams = Team::query()
            ->where('user:team_lead_id', $user:team_lead->id)
            ->get();
        $this->assertCount(1, $teams);
        $team = $teams->first();

        $response->assertRedirect(route('team.index'));
        $response->assertSessionHas('team.id', $team->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $team = Team::factory()->create();

        $response = $this->get(route('team.show', $team));

        $response->assertOk();
        $response->assertViewIs('team.show');
        $response->assertViewHas('team');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $team = Team::factory()->create();

        $response = $this->get(route('team.edit', $team));

        $response->assertOk();
        $response->assertViewIs('team.edit');
        $response->assertViewHas('team');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TeamController::class,
            'update',
            \App\Http\Requests\TeamUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $team = Team::factory()->create();
        $user:team_lead = App\Models\User::factory()->create();

        $response = $this->put(route('team.update', $team), [
            'user:team_lead_id' => $user:team_lead->id,
        ]);

        $team->refresh();

        $response->assertRedirect(route('team.index'));
        $response->assertSessionHas('team.id', $team->id);

        $this->assertEquals($user:team_lead->id, $team->user:team_lead_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $team = Team::factory()->create();

        $response = $this->delete(route('team.destroy', $team));

        $response->assertRedirect(route('team.index'));

        $this->assertModelMissing($team);
    }
}
