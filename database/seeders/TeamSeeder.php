<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::factory()->count(5)->create()->each(function(Team $team) {
            $uids = User::role('user')->get()->random(3)->pluck('id');
            $team->teamMembers()->attach($uids);
            $manager = User::role('manager')->get()->random(1)->first();
            $team->teamLead()->associate($manager);
            $team->save();
        });
    }
}
