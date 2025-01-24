<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

class TaskService {
    public function __construct(
        private TaskRepository $taskRepositoryInstance
    ) {}



    public function createTask(array $taskData): mixed {
        $taskData['created_by'] = Auth::id();
        $task = $this->taskRepositoryInstance->create($taskData);

        if (isset($taskData['dependencies'])) { // If dependencies are provided with the HTTP Request (If the task has dependencies), sync them (those dependencies tasks) in the pivot table with the newly created task
            $this->taskRepositoryInstance->syncTaskDependenciesInPivotTable($task, $taskData['dependencies']);
        }


        return $task->load('dependencies'); // Eager load dependencies for response
    }

}
