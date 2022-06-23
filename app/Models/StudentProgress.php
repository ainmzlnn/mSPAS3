<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'progress_id',
        'progress',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function progress()
    {
        return $this->belongsTo(ModuleProgress::class);
    }
}
