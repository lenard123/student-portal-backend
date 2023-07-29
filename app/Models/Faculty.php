<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('faculty', function (Builder $builder) {
            $builder->where('role', self::ROLE_FACULTY);
        });
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}