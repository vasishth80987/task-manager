<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:400'],
            'description' => ['required', 'string'],
            'creation_date' => ['nullable'],
            'completion' => ['required'],
            'user:owner_id' => ['required', 'integer', 'exists:App\Models\Users,id'],
        ];
    }
}
