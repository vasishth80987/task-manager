<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->hasRole('admin') || ($user->hasPermissionTo('view tasks'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || ($user->hasPermissionTo('create tasks'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        //only update if admin or owner
        return $user->hasRole('admin') || ($user->hasPermissionTo('edit tasks') && $task->owner->id == $user->id) ?
            Response::allow() : Response::deny('You do not own this task.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): Response
    {
        //only delete if admin or owner
        return $user->hasRole('admin') || ($user->hasPermissionTo('delete tasks') && $task->owner->id == $user->id) ?
            Response::allow() : Response::deny('You do not own this task.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->hasRole('admin');
    }
}
