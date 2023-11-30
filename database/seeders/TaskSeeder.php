<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(10)->create()->each(function(Task $task) {
            $manager = User::role('manager')->get()->random(1)->first();
            $task->owner()->associate($manager);
            $assignees = collect();
            foreach($manager->leads as $team){
                $assignees = $assignees->merge($team->teamMembers()->get());
            }
            $count = rand(0,$assignees->unique('id')->count());
            $task->assignedTo()->attach($assignees->unique('id')->random($count)->pluck('id'));
            $task->save();
        });


    }
}
