<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user:team_lead_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user:team_lead_id' => 'integer',
    ];

    public function teamLead(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'teamMembers');
    }
}
