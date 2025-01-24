<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository {
    public function __construct(
        private Task $model
    ) {}



    public function create(array $taskData): mixed {
        return $this->model->create($taskData);
    }

    public function syncTaskDependenciesInPivotTable(Task $taskModel, array $dependenciesArray): void {
        $taskModel->dependencies()->sync($dependenciesArray);
    }

}
