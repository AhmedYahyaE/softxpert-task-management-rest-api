<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'created_by',
        'title',
        'description',
        'status',
        'due_date'
    ];



    // Assigned user
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    // The 'manager' who created the task
    public function creatorUser(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }



    // The tasks that this task depends on
    public function dependencies(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_dependencies_pivot', 'task_id', 'dependency_id')->withTimestamps();
    }

    // The tasks that depend on this task
    public function dependentTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_dependencies_pivot', 'dependency_id', 'task_id')->withTimestamps();
    }

}
