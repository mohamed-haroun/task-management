<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'user_id'
    ];

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /*
     * The creator of the task list
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // The tasks belongs to task list
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
