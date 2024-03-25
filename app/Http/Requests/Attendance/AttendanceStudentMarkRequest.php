<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class AttendanceStudentMarkRequest extends FormRequest
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
        $subject_id = Route::current()->parameter('subject_id');

        return [
            'student_id' => [
                'required','numeric',
                Rule::exists('students', 'id')->where(function ($query) use ($student_id)  {
                    $query->where('id', $student_id);
                }),
            ],
            'subject_id' => [
                'required','numeric',
                Rule::exists('subjects', 'id')->where(function ($query) use ($subject_id)  {
                    $query->where('id', $subject_id)->where('teacher_id',auth()->user()->id);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['student_id' => Route::current()->parameter('student_id')]);
        $this->merge(['subject_id' => Route::current()->parameter('subject_id')]);
    }

    public function messages()
    {
    return [
        'student_id.required' => 'The student ID is required.',
        'student_id.exists' => 'The selected student ID is invalid.',
        
        'subject_id.required' => 'The subject ID is required.',
        'subject_id.exists' => 'The selected subject ID is invalid.',
        ];
    }
}
