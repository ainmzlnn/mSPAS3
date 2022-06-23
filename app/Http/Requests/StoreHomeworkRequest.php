<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('teacher');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'description' => ['required', 'string', 'min:5'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ];
    }
}
