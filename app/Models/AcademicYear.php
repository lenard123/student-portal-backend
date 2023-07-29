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
}
