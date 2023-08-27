<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_GRADED = 'graded';

    public function files()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
