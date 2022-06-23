<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['subject_id', 'description', 'class_id', 'from', 'to'];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
    ];

    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function class(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function submissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    public function getCurrentStatusAttribute(): string
    {
        $total = Student::where('class_id', $this->class_id)->count();
        $submissions = $this->submissions()->count();

        return "$submissions/$total";
    }

    public function submissionRate(): float
    {
        $total = Student::where('class_id', $this->class_id)->count();
        $submissions = $this->submissions()->count();

        return $total ? $submissions / $total : 0;
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Student::class, Classes::class, 'id', 'class_id', 'class_id', 'id');
    }

    public function isDue(): bool
    {
        return now()->startOfDay()->between($this->from, $this->to);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('from', '<=', now())->where('to', '>=', now());
    }

    public function scopeIsAvailable(Builder $query)
    {
        return $query->where('from', '<=', now());
    }
}
