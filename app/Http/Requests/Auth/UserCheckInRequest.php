<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserCheckInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {        
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['user_id' => Route::current()->parameter('user_id')]);
    }

    public function messages()
    {
    return [
        'user_id.required' => 'User ID is required.',
        'user_id.exists' => 'The selected user ID is invalid.',
        ];
    }
}
