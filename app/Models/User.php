<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static withoutAdmins()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
        'phone',
        'picture',
        'remember_token',
        'father_name',
        'father_phone',
        'father_email',
        'mother_name',
        'mother_phone',
        'mother_email',
        'address',
        'class_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function classes(){
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function scopeWithoutAdmins(Builder $query)
    {
        return $query->whereDoesntHave('roles', function (Builder $query) {
            $query->where('name', 'admin');
        });
    }

    public function scopeOnlyTeachers(Builder $query)
    {
        return $query->whereHas('roles', function (Builder $query) {
            $query->where('name', 'teacher');
        });
    }

    public function scopeOnlyParents(Builder $query)
    {
        return $query->whereHas('roles', function (Builder $query) {
            $query->where('name', 'parent');
        });
    }

    public function getPictureAttribute($value)
    {
        return $value ? url('/storage/' . $value) : $value;
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
