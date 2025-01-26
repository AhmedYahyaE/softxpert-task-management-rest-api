<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use App\Models\Task;

class NoSelfDependency implements ValidationRule
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

        // Check Self-Dependency (if one of the provided dependencies in the request is the task itself) (A task cannot depend on itself)
        if (in_array($this->taskModel->id, $taskDependenciesArray)) { // Check if the task is not included in its own dependencies
            Log::error('Task ID: ' . $this->taskModel->id . ' Task Dependencies: ' . json_encode($taskDependenciesArray));
            // throw new \Exception('Task cannot depend on itself! Change dependency ID ' . $this->taskModel->id . ' in your request!');
            $fail('Task cannot depend on itself! Change dependency ID ' . $this->taskModel->id . ' in your request!');
        }
    }
}
