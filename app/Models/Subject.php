<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }
}
