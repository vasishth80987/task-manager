<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Team;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'team_lead_id' => \App\Models\User::role('manager')->get()->random(1)->first()->id,
        ];
    }

    /**
     * Configure the model factory.
     * Allocate team members
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Team $team) {
            return $team->teamMembers()->attach(User::all('id')->random(3));
        });
    }
}
