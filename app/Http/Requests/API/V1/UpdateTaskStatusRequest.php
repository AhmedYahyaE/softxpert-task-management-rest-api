<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Enums\TaskStatusEnum;

class UpdateTaskStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;

        // Check if the 'user' owns the task    // Only 'user' role allowd: 'user' role is already checked by Spatie Laravel Permission package's middleware in api.php
        return Gate::allows('updateStatus', $this->route('id')); // $this->route('id') is an instance of the Task model due to Route Model Binding
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in([TaskStatusEnum::PENDING->value, TaskStatusEnum::COMPLETED->value, TaskStatusEnum::CANCELED->value])]
        ];
    }
}
