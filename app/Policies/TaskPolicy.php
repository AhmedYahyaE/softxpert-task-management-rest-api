<?php

namespace App\Policies;

use App\Models\{
    User, Task
};

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }



    // For 'user' Role Only
    public function updateStatus(User $user, Task $task): bool
    {
        // Check if the 'user' is the owner of the task
        return $user->id === $task->user_id; // Only 'user' role allowd: 'user' role is already checked by Spatie Laravel Permission package's middleware in api.php
    }
}
