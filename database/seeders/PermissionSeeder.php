<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method seeds the permissions table with predefined permissions.
     * It creates permissions for users, tasks, and teams with basic CRUD (Create, Read, Update, Delete) operations.
     * Additionally, it creates permissions for tasks with a specific guard 'sanctum'.
     */
    public function run(): void
    {
        // Create permissions related to user operations
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Create permissions related to task operations
        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);

        // Create permissions related to task operations with 'sanctum' guard
        // These are specific to APIs using the Sanctum guard
        Permission::create(['guard_name' => 'sanctum', 'name' => 'view tasks']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'create tasks']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'edit tasks']);
        Permission::create(['guard_name' => 'sanctum', 'name' => 'delete tasks']);

        // Create permissions related to team operations
        Permission::create(['name' => 'view teams']);
        Permission::create(['name' => 'create teams']);
        Permission::create(['name' => 'edit teams']);
        Permission::create(['name' => 'delete teams']);
    }
}
