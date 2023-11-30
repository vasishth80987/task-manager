<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_lead_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'team_lead_id' => 'integer',
    ];

    // Attributes that should be treated as dates
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Date format for the model's date fields
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Relationship to the User model (team lead of the team).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamLead(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'team_lead_id');
    }

    /**
     * Relationship to the User model (users that are team members).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'teamMembers');
    }

    /**
     * Model event for deleting a team.
     * Detaches all members when a team is deleted.
     */
    protected static function booted()
    {
        static::deleting(function (Team $team) {
            // Detach all team members before deleting the team
            $team->teamMembers()->detach();
        });
    }
}
