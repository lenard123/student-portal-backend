<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;

    const STATUS_PREPARATION = 'preparation';
    const STATUS_ENROLLMENT = 'enrollment';
    const STATUS_STARTED = 'started';
    const STATUS_ENDED = 'ended';

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function enrollees()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function gradeLevels(): HasMany
    {
        return $this->hasMany(GradeLevel::class, 'department', 'department');
    }

    public static function getActiveAcademicYear($department)
    {
        return AcademicYear::where('department', $department)
            ->where('status', '!=', self::STATUS_ENDED)
            ->first();
    }
}
