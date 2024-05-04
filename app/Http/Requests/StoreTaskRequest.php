<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'task_list_id' => 'required|integer|exists:task_lists,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|date_format:Y-m-d H:i:s',
            'priority' => 'required|string|in:low,medium,high',
            'assigned_to' => 'sometimes|integer|exists:users,id',
        ];
    }
}
