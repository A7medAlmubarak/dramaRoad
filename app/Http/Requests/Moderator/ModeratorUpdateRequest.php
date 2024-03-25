<?php

namespace App\Http\Requests\Moderator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class ModeratorUpdateRequest extends FormRequest
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
        $mod_id = Route::current()->parameter('moderator_id');

        return [
            'moderator_id' => [
                'required','numeric',
                Rule::exists('moderators', 'id')->where(function ($query) use ($mod_id)  {
                    $query->where('id', $mod_id)->whereNull('deleted_at');
                }),
            ],
            'salary' => 'required|numeric|min:1',
            'employment_date' => 'required|date',
            'resignation_date' => 'date',
            'vacations' => 'required|numeric',
            'rewards' => 'required|numeric',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['moderator_id' => Route::current()->parameter('moderator_id')]);
    }

}
