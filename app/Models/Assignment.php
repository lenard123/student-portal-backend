<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    private ?Student $student = null;


    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    public function files()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class)
            ->with('files')
            ->when($this->student != null, fn ($q) => $q->where('student_id', $this->student->id));
    }
}
