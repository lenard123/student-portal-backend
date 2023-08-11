<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';

    protected $attributes = [
        'role' => self::ROLE_STUDENT,
    ];

    protected $with = ['currentRegistration'];

    public function hasPendingRegistration()
    {
        return $this->pendingRegistration()->exists();
    }

    public function registration()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function pendingRegistration()
    {
        return $this->registration()->where('status', Enrollee::STATUS_PENDING);
    }

    public function currentRegistration()
    {
        return $this->hasOne(Enrollee::class)
            ->where('status', Enrollee::STATUS_ENROLLED)
            ->whereHas('academicYear', function( Builder $q) {
                $q->where('status', AcademicYear::STATUS_STARTED)
                  ->orWhere('status', AcademicYear::STATUS_ENROLLMENT);
            });
    }

    protected static function booted(): void
    {
        static::addGlobalScope('student', function (Builder $builder) {
            $builder->where('role', self::ROLE_STUDENT);
        });
    }
}
