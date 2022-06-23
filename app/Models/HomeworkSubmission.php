<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'homework_id', 'file', 'comment', 'grade', 'feedback'];

    public function getFileAttribute($value)
    {
        return $value ? url('/storage/' . $value) : $value;
    }

    public function getFeedbackAttribute($value)
    {
        return $value ? url('/storage/' . $value) : $value;
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
