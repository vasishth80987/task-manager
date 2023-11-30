<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Attributes hidden from array/json serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attribute type casting
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Date attributes
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Date format for the model
    protected $dateFormat = 'Y-m-d H:i:s';

    // Relationship: User owns multiple tasks
    public function owns(): HasMany
    {
        return $this->hasMany(\App\Models\Task::class, 'owner_id');
    }

    // Relationship: User assigned to multiple tasks
    public function assigned(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Task::class, 'assignedTo');
    }

    // Relationship: User leads multiple teams
    public function leads(): HasMany
    {
        return $this->hasMany(\App\Models\Team::class, 'team_lead_id');
    }

    // Relationship: User belongs to multiple teams
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Team::class, 'teamMembers');
    }

    // Model event: Handle related records before deleting a user
    protected static function booted()
    {
        static::deleting(function (User $user) {
            // Delete tasks owned by the user
            foreach ($user->owns as $task) {
                $task->delete();
            }
            // Delete teams led by the user
            foreach ($user->leads as $team) {
                $team->delete();
            }
            // Detach from assigned tasks and teams
            $user->assigned()->detach();
            $user->teams()->detach();
        });
    }
}
