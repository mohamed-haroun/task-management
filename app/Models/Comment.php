<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'task_id',
        'comment_id'
    ];

    protected $table = 'comments';

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function childComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }
}
