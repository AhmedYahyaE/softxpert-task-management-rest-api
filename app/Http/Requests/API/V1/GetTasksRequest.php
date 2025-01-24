<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTasksRequest extends FormRequest
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
            'status'        => ['nullable', 'string', Rule::in(['pending', 'completed', 'canceled'])],
            'due_date_from' => ['nullable', 'date', 'date_format:Y-m-d', 'required_with:due_date_to'  , 'before_or_equal:due_date_to'],
            'due_date_to'   => ['nullable', 'date', 'date_format:Y-m-d', 'required_with:due_date_from', 'after_or_equal:due_date_from'],
            'assignee_id'   => ['nullable', 'integer', 'exists:users,id']
        ];
    }
}
