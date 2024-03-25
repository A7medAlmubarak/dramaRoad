<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class StudentCheckInRequest extends FormRequest
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
        $student_id = Route::current()->parameter('student_id');
        return [
            'student_id' => [
                'required','numeric',
                Rule::exists('students', 'id')->where(function ($query) use ($student_id)  {
                    $query->where('id', $student_id);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['student_id' => Route::current()->parameter('student_id')]);
    }

    public function messages()
    {
    return [
        'student_id.required' => 'The student ID is required.',
        'student_id.exists' => 'The selected student ID is invalid.',
        ];
    }
}
