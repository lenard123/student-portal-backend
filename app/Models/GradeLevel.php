<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    public function subjects()
    {
        $active_id = $this->academicYear()->id;
        return $this->belongsToMany(Subject::class, 'academic_year_curriculum')
            ->where('academic_year_id', $active_id);
    }

    public function fees()
    {
        $active_id = $this->academicYear()->id;
        return $this->hasMany(Fee::class)
            ->where('academic_year_id', $active_id);
    }

    public function academicYear()
    {
        return AcademicYear::getActiveAcademicYear($this->department);
    }

}
