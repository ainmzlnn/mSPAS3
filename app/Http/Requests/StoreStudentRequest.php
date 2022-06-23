<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'age_id' => ['required', 'integer', 'exists:ages,id'],
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'gender_id' => ['required', 'integer', 'exists:genders,id'],
            'address' => ['required', 'string', 'max:255'],
            'race_id' => ['required', 'integer', 'exists:races,id'],
            'religion_id' => ['required', 'integer', 'exists:religions,id'],
            'picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
