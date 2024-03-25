<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class TeacherCheckInRequest extends FormRequest
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
        $teacher_id = Route::current()->parameter('teacher_id');
        return [
            'teacher_id' => [
                'required','numeric',
                Rule::exists('teachers', 'id')->where(function ($query) use ($teacher_id)  {
                    $query->where('id', $teacher_id);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['teacher_id' => Route::current()->parameter('teacher_id')]);
    }

    public function messages()
    {
    return [
        'teacher_id.required' => 'The teacher ID is required.',
        'teacher_id.exists' => 'The selected teacher ID is invalid.',
        ];
    }
}
