<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    // Relationships
    public function tasks(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
