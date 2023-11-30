<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'creation_date',
        'completion',
        'owner_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'creation_date' => 'timestamp',
        'completion' => 'boolean',
        'owner_id' => 'integer',
    ];

    // Attributes that should be treated as dates
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Date format for the model's date fields
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Relationship to the User model (owner of the task).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Relationship to the User model (users assigned to the task).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedTo(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'assignedTo');
    }

    /**
     * Model event for deleting a task.
     * Detaches all assigned users when a task is deleted.
     */
    protected static function booted()
    {
        static::deleting(function (Task $task) {
            // Detach all users assigned to the task before deleting it
            $task->assignedTo()->detach();
        });
    }
}
