<?php

namespace App\Http\Requests\Level;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class LevelUpdateRequest extends FormRequest
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
        $courseId = Route::current()->parameter('course_id');
        $levelId = Route::current()->parameter('level_id');
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'date|after:start_date',
            'shift_type' => 'required|numeric|min:1|max:3',
            'level_number' => 'required|numeric|min:1',
            'course_id' => [
                'required','numeric',
                Rule::exists('courses', 'id')->where(function ($query) use ($courseId)  {
                    $query->where('id', $courseId);
                }),
            ],
            'level_id' => [
                'required','numeric',
                Rule::exists('levels', 'id')->where(function ($query) use ($levelId)  {
                    $query->where('id', $levelId);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['course_id' => Route::current()->parameter('course_id')] );
        $this->merge(['level_id' => Route::current()->parameter('level_id')] );
    }
}
