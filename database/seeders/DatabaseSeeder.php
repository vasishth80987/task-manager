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
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'id' => 1,
             'name' => 'Admin User',
             'password' => 'password',
             'email' => 'admin@example.com',
         ]);

        \App\Models\User::factory()->create([
            'id' => 2,
            'name' => 'Test User',
            'password' => 'password',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
