<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\App\Models\User;
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
            'owner_id' => \App\Models\User::factory(),
        ];
    }
}
