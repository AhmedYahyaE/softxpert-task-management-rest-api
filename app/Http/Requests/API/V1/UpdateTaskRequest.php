<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->hasRole('manager'); // Already checked by the 'role:manager' middleware in api.php!
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
            'status'         => ['sometimes', 'string', Rule::in(['pending', 'completed', 'canceled'])],
            'due_date'       => ['sometimes', 'date', 'date_format:Y-m-d'],

            'dependencies'   => ['sometimes', 'array'],
            'dependencies.*' => ['integer', 'exists:tasks,id']
        ];
    }
}
