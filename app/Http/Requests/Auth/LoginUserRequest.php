<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
        $loginField = $this->input('login_field');

        return [
            'login_field' => [
                'required',
                function ($attribute, $value, $fail) {
                    $user = User::where(function ($query) use ($value) {
                        $query->where('email', $value)
                            ->orWhere('username', $value);
                    })->first();

                    if (!$user) {
                        $fail('البيانات اللتي ادخلتها خاطئة');
                    }
                },
            ],
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'login_field.required' => 'يرجى إدخال البريد الإلكتروني أو اسم المستخدم',
            'login_field.exists' => 'البريد الإلكتروني أو اسم المستخدم غير صحيح',
            'password.required' => 'يرجى إدخال كلمة المرور',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على 6 أحرف',
        ];
    }


}
