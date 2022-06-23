<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'age_id', 'class_id', 'gender_id', 'race_id', 'religion_id', 'address', 'picture', 'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function modules()
    {
        return $this->hasManyThrough(Module::class, Age::class, 'id', 'age_id', 'age_id', 'id');
    }

    public function getPictureAttribute($value)
    {
        return $value ? url('/storage/' . $value) : $value;
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function homeworks()
    {
        return $this->hasManyThrough(Homework::class, Classes::class, 'id', 'class_id', 'class_id', 'id');
    }

    public function hasSubmitted(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->exists();
    }

    public function isGraded(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->whereNotNull('grade')->exists();
    }

    public function homework(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->latest()->first();
    }

    public function submission(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->latest()->first();
    }

    public function moduleProgress()
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function getTotalModuleScore(Module $module)
    {
        $total = $module->progresses()->count() * 100;
        if ($total === 0) {
            return 0;
        }
        $progressIds = $module->progresses()->pluck('id')->toArray();
        $progresses = $this->moduleProgress()->whereIn('progress_id', $progressIds)->sum('progress');

        return $progresses / $total * 100;
    }

    public function getProgress(ModuleProgress $progress)
    {
        return $this->moduleProgress()->where('progress_id', $progress->id)->first();
    }

    public function canUploadHomework(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->count() === 0;
    }

    public function submissions()
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    public function hasFeedback(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->whereNotNull('feedback')->exists();
    }

    public function getFeedback(Homework $homework)
    {
        return $homework->submissions()->where('student_id', $this->id)->whereNotNull('feedback')->first('feedback')->feedback;
    }
}
