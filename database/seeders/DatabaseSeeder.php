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
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
         \App\Models\User::factory()->create([
             'id' => 1,
             'name' => 'Admin User',
             'password' => 'password',
             'email' => 'admin@example.com',
         ])->assignRole('admin');

        \App\Models\User::factory()->create([
            'id' => 2,
            'name' => 'Team Manager 1',
            'password' => 'password',
            'email' => 'manager1@example.com',
        ])->assignRole('manager');

        \App\Models\User::factory()->create([
            'id' => 3,
            'name' => 'Team Manager 2',
            'password' => 'password',
            'email' => 'manager2@example.com',
        ])->assignRole('manager');

        \App\Models\User::factory()->create([
            'id' => 4,
            'name' => 'Dev 1',
            'password' => 'password',
            'email' => 'dev1@example.com',
        ]);

        \App\Models\User::factory()->create([
            'id' => 5,
            'name' => 'Dev 2',
            'password' => 'password',
            'email' => 'dev2@example.com',
        ]);

        \App\Models\User::factory(10)->create();

        $this->call([
            TeamSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
