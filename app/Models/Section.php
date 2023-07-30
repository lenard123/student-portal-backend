<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
