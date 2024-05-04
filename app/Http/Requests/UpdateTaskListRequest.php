<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskListRequest extends FormRequest
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
            'user_id' => 'sometimes|integer|exists:users,id',
            'project_id' => 'sometimes|integer|exists:projects,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
        ];
    }
}
