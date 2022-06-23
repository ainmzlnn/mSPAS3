<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeworkSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isHomeworkNotDue() && $this->isHomeWorkNotGraded();
    }

    private function isHomeworkNotDue()
    {
        return $this->route('homework')?->isDue();
    }

    private function isHomeWorkNotGraded(): bool
    {
        $student = $this->route('student');
        $homework = $this->route('homework');

        return !$homework->submissions()->where('student_id', $student->id)->whereNotNull('grade')->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'file'],
            'comment' => ['nullable'],
        ];
    }
}
