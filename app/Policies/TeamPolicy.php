<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
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
    public function view(User $user, Team $team): bool
    {
        return $user->hasRole('admin') || ($user->hasPermissionTo('view teams'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || ($user->hasPermissionTo('create teams'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): Response
    {
        //only update if admin or team lead
        return $user->hasRole('admin') || ($user->hasPermissionTo('edit teams') && $team->teamLead->id == $user->id) ?
            Response::allow() : Response::deny('You do not manage this team.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): Response
    {
        //only delete if admin or team lead
        return $user->hasRole('admin') || ($user->hasPermissionTo('delete teams') && $team->teamLead->id == $user->id) ?
            Response::allow() : Response::deny('You do not manage this team.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Team $team): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Team $team): bool
    {
        return $user->hasRole('admin');
    }
}
