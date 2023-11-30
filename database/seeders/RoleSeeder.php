<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);

//        $adminRole->givePermissionTo(Permission::all());
        $managerRole->syncPermissions(['view tasks', 'create tasks', 'edit tasks', 'delete tasks',
            'view teams', 'create teams', 'edit teams', 'delete teams']);
        $userRole->syncPermissions(['view tasks', 'view teams']);

        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole('user');
        }
        User::find(1)->assignRole('admin');
        User::find(2)->assignRole('manager');
        User::find(3)->assignRole('manager');

    }
}
