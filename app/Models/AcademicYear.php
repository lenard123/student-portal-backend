<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    const STATUS_PREPARATION = 'preparation';
    const STATUS_ENROLLMENT = 'enrollment';
    const STATUS_STARTED = 'started';
    const STATUS_ENDED = 'ended';

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function enrollees()
    {
        return $this->hasMany(Enrollee::class);
    }

    public static function getActiveAcademicYear($department)
    {
        return AcademicYear::where('department', $department)
            ->where('status', '!=', self::STATUS_ENDED)
            ->first();
    }
}
