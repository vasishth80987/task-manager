<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'creation_date',
        'completion',
        'owner_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'creation_date' => 'timestamp',
        'completion' => 'boolean',
        'owner_id' => 'integer',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function assignedTo(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'assignedTo');
    }
}
