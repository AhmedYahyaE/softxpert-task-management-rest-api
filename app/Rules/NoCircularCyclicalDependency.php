<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use App\Models\Task;

class NoCircularCyclicalDependency implements ValidationRule
{
    public function __construct(
        private Task $taskModel
    ) {}



    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskDependenciesArray = $value;

        // Check Circular/Cyclical Dependency (if one of the provided dependencies in the request is already dependent on the task)
        $currentTaskDependentTasks = $this->taskModel->dependentTasks()->pluck('task_dependencies_pivot.task_id')->toArray(); // Get the IDs of the tasks that are dependent on the current task

        foreach ($taskDependenciesArray as $TaskDependencyID) {
            if (in_array($TaskDependencyID, $currentTaskDependentTasks)) { // Check if the task is not dependent on a task that is already dependent on it

                Log::error('Task ID: ' . $this->taskModel->id . ' Task Dependencies: ' . json_encode($taskDependenciesArray));
                // throw new \Exception('Circular Dependency Detected: Dependency ID ' . $TaskDependencyID . ' is already dependent on the current task!');
                $fail('Circular Dependency Detected: Dependency ID ' . $TaskDependencyID . ' is already dependent on the current task!');
            }
        }
    }
}
