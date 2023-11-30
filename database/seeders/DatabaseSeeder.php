<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'id' => 1,
             'name' => 'Admin User',
             'password' => 'password',
             'email' => 'admin@example.com',
         ]);

        \App\Models\User::factory()->create([
            'id' => 2,
            'name' => 'Team Manager 1',
            'password' => 'password',
            'email' => 'test1@example.com',
        ]);

        \App\Models\User::factory()->create([
            'id' => 3,
            'name' => 'Team Manager 2',
            'password' => 'password',
            'email' => 'test2@example.com',
        ]);

        \App\Models\User::factory()->create([
            'id' => 4,
            'name' => 'Dev 1',
            'password' => 'password',
            'email' => 'test3@example.com',
        ]);

        \App\Models\User::factory()->create([
            'id' => 5,
            'name' => 'Dev 2',
            'password' => 'password',
            'email' => 'test4@example.com',
        ]);

        \App\Models\User::factory(10)->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            TeamSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
