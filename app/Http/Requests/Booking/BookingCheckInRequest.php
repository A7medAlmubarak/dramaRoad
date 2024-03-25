<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class BookingCheckInRequest extends FormRequest
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
        $bookId = Route::current()->parameter('book_id');
        return [
            'course_id' => [
                'required','numeric',
                Rule::exists('courses', 'id')->where(function ($query) use ($courseId)  {
                    $query->where('id', $courseId);
                }),
            ],
            'book_id' => [
                'required','numeric',
                Rule::exists('Bookings', 'id')->where(function ($query) use ($bookId)  {
                    $query->where('id', $bookId);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['course_id' => Route::current()->parameter('course_id')] );
        $this->merge(['book_id' => Route::current()->parameter('book_id')] );
    }
}
