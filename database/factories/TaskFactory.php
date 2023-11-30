<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Task;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'creation_date' => $this->faker->dateTime(),
            'completion' => $this->faker->boolean(),
            'owner_id' => \App\Models\User::role('manager')->get()->random(1)->first()->id,
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
        return $this->afterCreating(function (Task $task) {
            $users = collect();
            foreach($task->owner->leads as $team)
                $users = $users->merge($team->teamMembers()->get());
            $count = rand(0,$users->unique('id')->count());
            return $task->assignedTo()->attach($users->unique('id')->random($count)->pluck('id')->toArray());
        });
    }
}
