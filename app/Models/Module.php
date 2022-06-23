<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['age_id', 'subject_id', 'month_id'];

    public function progresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ModuleProgress::class);
    }

    public function subject(){
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function age(){
        return $this->hasOne(Age::class, 'id', 'age_id');
    }

    public function month(){
        return $this->hasOne(Month::class, 'id', 'month_id');
    }

    public function students(){
        return $this->hasManyThrough(Student::class, Age::class, 'id', 'age_id', 'age_id', 'id');
    }
}
