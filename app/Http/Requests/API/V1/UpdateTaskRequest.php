<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\NoSelfDependency;
use App\Rules\NoCircularCyclicalDependency;
use App\Enums\{
    TaskStatusEnum,
    UserRoleEnum
};

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->hasRole(UserRoleEnum::MANAGER->value); // Already checked by the 'role:manager' middleware in api.php!
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'        => ['sometimes', 'integer', 'exists:users,id'],
            'title'          => ['sometimes', 'string', 'max:50'],
            'description'    => ['sometimes', 'string', 'max:255'],
            'status'         => ['sometimes', 'string', Rule::in([TaskStatusEnum::PENDING->value, TaskStatusEnum::COMPLETED->value, TaskStatusEnum::CANCELED->value])],
            'due_date'       => ['sometimes', 'date', 'date_format:Y-m-d'],

            'task_dependencies'   => ['sometimes', 'array', new NoSelfDependency($this->route('id')), new NoCircularCyclicalDependency($this->route('id'))], // $this->route('id') is an instance of the Task model due to Route Model Binding
            'task_dependencies.*' => ['integer', 'exists:tasks,id']
        ];
    }
}
