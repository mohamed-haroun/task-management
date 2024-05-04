<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_list_id' => 'sometimes|integer|exists:task_lists,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'due_date' => 'sometimes|date|date_format:Y-m-d H:i:s',
            'status' => 'sometimes|string|in:pending,in progress,completed,incomplete',
            'priority' => 'sometimes|string|in:low,medium,high',
            'assigned_to' => 'sometimes|integer|exists:users,id',
        ];
    }
}
