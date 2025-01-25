<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Enums\TaskStatusEnum;
use Illuminate\Support\Facades\Log;
use App\Repositories\{
    TaskRepository,
    UserRepository
};

class TaskService {
    public function __construct(
        private TaskRepository $taskRepositoryInstance,
        private UserRepository $userRepositoryInstance
    ) {}



    public function createTask(array $taskData): mixed {
        $taskData['created_by'] = Auth::id();

        $newTask = null; // To be passed By Reference to the DB Transaction (to make it available outside the Transaction to 'return'))

        // Database Transaction
        DB::Transaction(function () use ($taskData, &$newTask) { // $newTask is passed By Reference to the DB Transaction (to make it available outside the Transaction to 'return'))
            // Create the task
            $newTask = $this->taskRepositoryInstance->create($taskData);

            // Sync the task dependencies of the task in the `task_dependencies_pivot` table (if provided in the HTTP Request)
            if (isset($taskData['task_dependencies'])) { // If task_dependencies are provided with the HTTP Request (If the task has dependencies), sync them (those dependencies tasks) in the pivot table with the newly created task
                $this->taskRepositoryInstance->syncTaskDependenciesInPivotTable($newTask, $taskData['task_dependencies']);
            }
        });


        return $newTask->load('taskDependencies'); // Eager load taskDependencies() for response
    }

    public function getFilteredTasks(array $filters): mixed {
        return $this->taskRepositoryInstance->applyFilters($filters);
    }

    public function updateTask(Task $taskModel, array $taskData) {
        $this->checkIfAllTaskDependenciesCompleted($taskModel, $taskData);

        $taskData['created_by'] = Auth::id();

        // Database Transaction
        DB::Transaction(function () use ($taskModel, $taskData) {
            // Update the task
            $this->taskRepositoryInstance->update($taskModel, $taskData);

            // Updae the task dependencies of the task in the `task_dependencies_pivot` table (if provided in the HTTP Request)
            if (isset($taskData['task_dependencies'])) { // If task_dependencies are provided with the HTTP Request (If the task has dependencies), update them (those dependencies tasks) in the pivot table with the updated task
                $this->checkSelfAndCircularDependency($taskModel, $taskData['task_dependencies']);
                $this->taskRepositoryInstance->syncTaskDependenciesInPivotTable($taskModel, $taskData['task_dependencies']);
            }
        });


        return $taskModel->load('taskDependencies'); // Eager load taskDependencies() for response
    }

    private function checkIfAllTaskDependenciesCompleted(Task $taskModel, $taskData): void {
        // Check if the task is being marked as completed and if it has any dependencies that are NOT yet completed
        if (
            isset($taskData['status'])
            &&
            $taskData['status'] === TaskStatusEnum::COMPLETED->value
            &&
            $this->taskRepositoryInstance->areAllTaskDependenciesCompleted($taskModel) === false
        ) {
            Log::error('Task ID: ' . $taskModel->id . ' Task Dependencies: ' . json_encode($taskModel->taskDependencies->pluck('id')->toArray()));
            throw new \Exception('Cannot mark task as completed until its all dependencies are completed!');
        }
    }

    private function checkSelfAndCircularDependency(Task $taskModel, array $taskDependenciesArray) {
        // Check Self-Dependency (if one of the provided dependencies in the request is the task itself) (A task cannot depend on itself)
        if (in_array($taskModel->id, $taskDependenciesArray)) { // Check if the task is not included in its own dependencies
            Log::error('Task ID: ' . $taskModel->id . ' Task Dependencies: ' . json_encode($taskDependenciesArray));
            throw new \Exception('Task cannot depend on itself! Change dependency ID ' . $taskModel->id . ' in your request!');
        }


        // Check Circular/Cyclical Dependency (if one of the provided dependencies in the request is already dependent on the task)
        $currentTaskDependentTasks = $taskModel->dependentTasks()->pluck('task_dependencies_pivot.task_id')->toArray(); // Get the IDs of the tasks that are dependent on the current task

        foreach ($taskDependenciesArray as $TaskDependencyID) {
            if (in_array($TaskDependencyID, $currentTaskDependentTasks)) { // Check if the task is not dependent on a task that is already dependent on it

                Log::error('Task ID: ' . $taskModel->id . ' Task Dependencies: ' . json_encode($taskDependenciesArray));
                throw new \Exception('Circular Dependency Detected: Dependency ID ' . $TaskDependencyID . ' is already dependent on the current task!');
            }
        }
    }



    public function updateTaskStatus(Task $taskModel, array $taskData) {
        $this->checkIfAllTaskDependenciesCompleted($taskModel, $taskData);
        $updatedStatusTask = $this->taskRepositoryInstance->update($taskModel, $taskData);


        return $updatedStatusTask->load('taskDependencies'); // Eager load taskDependencies() for response
    }

    public function getUserTasks(int $userID): mixed {
        $userModel = $this->userRepositoryInstance->getUserByID($userID);

        return $this->taskRepositoryInstance->getUserTasks($userModel);
    }

}
