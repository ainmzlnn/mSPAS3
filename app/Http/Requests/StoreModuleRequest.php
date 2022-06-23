<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
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
            'age_id' => ['required', 'integer', 'exists:ages,id'],
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'month_id' => ['required', 'integer', 'exists:months,id'],
            'progress.*' => ['required', 'array'],
            'progress.*.target_id' => ['nullable', 'required_with:progress.*.progress', 'integer', 'exists:targets,id'],
            'progress.*.progress' => ['nullable', 'required_with:progress.*.target_id', 'string', 'max:2048'],
        ];
    }
}
