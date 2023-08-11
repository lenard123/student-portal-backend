<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    private ?AcademicYear $academic_year = null;

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

    public function sections()
    {
        $active_id = $this->academicYear()->id;
        return $this->hasMany(Section::class)
            ->where('academic_year_id', $active_id);
    }

    public function academicYear()
    {
        if ($this->academic_year == null) {
            $this->academic_year = AcademicYear::getActiveAcademicYear($this->department);
        }
        return $this->academic_year;
    }

}
