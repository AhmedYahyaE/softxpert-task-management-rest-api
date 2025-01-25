<?php

namespace App\Repositories;

use App\Models\{
    Task,
    User
};

class TaskRepository {
    public function __construct(
        private Task $model,
        private User $userModel
    ) {}



    public function create(array $taskData): mixed {
        return $this->model->create($taskData);
    }

    public function syncTaskDependenciesInPivotTable(Task $taskModel, array $dependenciesArray): void {
        $taskModel->taskDependencies()->sync($dependenciesArray);
    }

    // Decorator Pattern
    public function applyFilters(array $filters): mixed {
        $queryBuilderObject = $this->model->query();

        if (isset($filters['status'])) {
            $queryBuilderObject->where('status', $filters['status']);
        }

        if (isset($filters['assignee_id'])) {
            $queryBuilderObject->where('user_id', $filters['assignee_id']);
        }

        if (isset($filters['due_date_from']) && isset($filters['due_date_to'])) {
            $queryBuilderObject->whereBetween('due_date', [$filters['due_date_from'], $filters['due_date_to']]);
        }


        return $queryBuilderObject->get();
    }

    public function areAllTaskDependenciesCompleted(Task $taskModel): Bool {
        // dd($taskModel->taskDependencies()->where('status', '!=', 'completed')->pluck('status', 'task_dependencies_pivot.dependency_id'));
        return $taskModel->taskDependencies()->where('status', '!=', 'completed')->exists() !== true; // Check if there are any dependencies that are NOT completed!
    }

    public function update(Task $taskModel, array $taskData): mixed {
        $taskModel->update($taskData);

        return $taskModel;
    }

    public function getUserTasks(int $userID): mixed {
        $userModel = $this->userModel->findOrFail($userID);

        return $userModel->tasks()->get();
    }

}
