<?php

namespace App\Http\Requests\Teacher;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role_id', '!=', '3');
                })
            ]
        ];
    }

    public function messages()
    {
    return [
        'user_id.required' => 'User ID is required.',
        'user_id.exists' => 'The selected user is already an teacher or does not exist.',
        ];
    }

}
