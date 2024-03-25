<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class BookingApproveRequest extends FormRequest
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
        $bookId = Route::current()->parameter('book_id');
        return [
            'book_id' => [
                'required','numeric',
                Rule::exists('Bookings', 'id')->where(function ($query) use ($bookId)  {
                    $query->where('id', $bookId)->where('status',null);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['book_id' => Route::current()->parameter('book_id')] );
    }

    public function messages()
    {
    return [
        'book_id.required' => 'The Booking request ID is required.',
        'book_id.exists' => 'The selected Booking request ID is invalid or request is not pending approval.',
        ];
    }
}
