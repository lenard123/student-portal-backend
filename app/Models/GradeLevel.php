<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        $active_id = $this->academicYear()?->id;
        return $this->hasMany(Fee::class)
            ->when($active_id != null, function (Builder $q) use ($active_id) {
                $q->where('academic_year_id', $active_id);
            });
    }

    public function sections($active_id = null): HasMany
    {
        $active_id = $active_id ?? $this->academicYear()->id;
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
