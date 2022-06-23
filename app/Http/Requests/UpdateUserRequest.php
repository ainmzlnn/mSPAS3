<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fileToUpload' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'role' => ['required', Rule::in(['teacher', 'parent'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->route('user')->id)],
            'phone' => ['required', 'string', 'max:255'],
            'father_name' => ['required_if:role,parent'],
            'father_phone' => ['required_if:role,parent'],
            'father_email' => ['required_if:role,parent'],
            'mother_name' => ['required_if:role,parent'],
            'mother_phone' => ['required_if:role,parent'],
            'mother_email' => ['required_if:role,parent'],
            'address' => ['required_if:role,parent'],
            'class_id' => ['required_if:role,teacher'],
        ];
    }
}
