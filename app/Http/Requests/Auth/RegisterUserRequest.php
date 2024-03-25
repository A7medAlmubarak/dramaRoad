<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name'      => "required|string|max:255|regex:/^[A-Za-z0-9 _]+$/",
            'phone'     => "required|numeric|regex:/^09[0-9]{8}/|unique:users,phone",
            'email'     => "required|email|max:255|unique:users,email",
            //'username'     => "required|string|max:50|alpha_dash|unique:users,username",
            'password'  => "required|string|min:6|max:255",
            'gender_id'    => "required|numeric|min:1|max:2",
            ];
    }


    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال الاسم',
            'name.regex' => 'حقل الاسم يجب أن يحتوي فقط على الحروف والأرقام.',
            'phone.required' => 'يرجى إدخال رقم الهاتف',
            'phone.numeric' => 'يجب أن يكون رقم الهاتف رقمًا',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09 ويتكون من 10 أرقام',
            'phone.unique' => 'رقم الهاتف مسجل مسبقًا',
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بتنسيق صحيح',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفًا',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقًا',
            'username.required' => 'يرجى إدخال اسم المستخدم',
            'username.max' => 'يجب ألا يتجاوز اسم المستخدم 50 حرفًا',
            'username.unique' => 'اسم المستخدم مسجل مسبقًا',
            'username.alpha_dash' => 'حقل اسم المستخدم يجب أن يحتوي فقط على أحرف أبجدية وأرقام او (-) او .',
            'password.required' => 'يرجى إدخال كلمة المرور',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على 6 أحرف',
            'password.max' => 'يجب ألا تتجاوز كلمة المرور 255 حرفًا',
            'gender.required' => 'يرجى اختيار الجنس',
            'gender.numeric' => 'يجب أن يكون الجنس رقمًا',
            'gender.min' => 'قيمة الجنس غير صحيحة',
            'gender.max' => 'قيمة الجنس غير صحيحة',
        ];
    }

}
