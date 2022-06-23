<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleProgress extends Model
{
    use HasFactory;

    protected $fillable = ['progress', 'target_id', 'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
