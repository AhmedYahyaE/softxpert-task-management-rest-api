<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
            'user_id'     => ['required', 'integer', 'exists:users,id'],
            'title'       => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
            'status'      => ['required', 'string', Rule::in(['pending', 'completed', 'canceled'])],
            'due_date'    => ['nullable', 'date'],

            'dependencies'   => ['nullable', 'array'],
            'dependencies.*' => ['integer', 'exists:tasks,id']
        ];
    }
}
