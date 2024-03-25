<?php

namespace App\Http\Requests\Mark;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class MarkStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $subjectId = Route::current()->parameter('subject_id');

        return [
            'studentMarks.required' => 'The student marks are required.',
            'studentMarks.array' => 'The student marks must be an array.',
            'studentMarks.*.student_id.required' => 'The student ID is required.',
            'studentMarks.*.student_id.exists' => 'The selected student ID is invalid.',
            'studentMarks.*.mark.required' => 'The mark is required.',
            'studentMarks.*.mark.numeric' => 'The mark must be a numeric value.',
            'studentMarks.*.mark.min' => 'The mark must be at least 0.',
            'studentMarks.*.mark.max' => 'The mark must not exceed 100.',
            'subject_id' => [
                'required','numeric',
                Rule::exists('subjects', 'id')->where(function ($query) use ($subjectId)  {
                    $query->where('id', $subjectId);
                }),
            ],
        ];

    }

    protected function prepareForValidation(): void
    {
        $this->merge(['subject_id' => Route::current()->parameter('subject_id')]);
    }


}
