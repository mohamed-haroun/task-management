<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'start_date',
        'end_date'
    ];

    // Relationships
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_assignments', 'project_id', 'user_id')->withPivot('role');
    }

    public function taskList(): HasOne
    {
        return $this->hasOne(TaskList::class);
    }
}
