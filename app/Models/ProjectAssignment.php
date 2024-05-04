<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssignment extends Model
{
    use HasFactory;

    protected $table = 'project_assignments';
    protected $fillable = [
        'project_id',
        'user_id',
        'role'
    ];

    public $timestamps = false;
}
