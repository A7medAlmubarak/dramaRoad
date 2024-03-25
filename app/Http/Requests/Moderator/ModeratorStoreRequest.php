<?php

namespace App\Http\Requests\Moderator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class ModeratorStoreRequest extends FormRequest
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
                    $query->where('role_id', '!=', '2');
                })
            ],
            'salary' => 'numeric|min:1',
            'employment_date' => 'date',
            'resignation_date' => 'date',
            'vacations' => 'numeric',
            'rewards' => 'numeric',
        ];
    }

    public function messages()
    {
    return [
        'user_id.required' => 'User ID is required.',
        'user_id.exists' => 'The selected user is already an moderator or does not exist.',
        ];
    }
}
