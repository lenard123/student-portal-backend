<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_STUDENT = 'student';
    const ROLE_ADMIN = 'admin';
    const ROLE_FACULTY = 'faculty';

    const DEPARTMENT_PRESCHOOL = 'pre-school';
    const DEPARTMENT_ELEMENTARY = 'elementary';
    const DEPARTMENT_JUNIOR_HIGH = 'jhs';
    const DEPARTMENT_SENIOR_HIGH = 'shs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['fullname', 'avatar', 'department_label'];

    public function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->firstname} {$this->lastname}"
        );
    }

    public function getDepartmentLabelAttribute()
    {
        return match ($this->department) {
            null => '',
            self::DEPARTMENT_PRESCHOOL => 'Pre School',
            self::DEPARTMENT_ELEMENTARY => 'Elementary',
            self::DEPARTMENT_JUNIOR_HIGH => 'Junior Highschool',
            self::DEPARTMENT_SENIOR_HIGH => 'Senior Highschool',
        };
    }

    public function getAvatarAttribute()
    {
        if (!array_key_exists('avatar', $this->attributes) or $this->attributes['avatar'] == null) {
            $name = strtolower(urlencode($this->fullname));
            return "https://avatars.dicebear.com/api/initials/$name.svg";
        }

        if (str_starts_with($this->attributes['avatar'], 'http')) {
            return $this->attributes['avatar'];
        }

        return url('/storage/' . $this->attributes['avatar']);
    }

    public function toFaculty()
    {
        return new Faculty($this->attributes);
    }
}
