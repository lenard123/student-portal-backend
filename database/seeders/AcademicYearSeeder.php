<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicYear::create([
            'name' => env('SP_SCHOOL_YEAR', '2021-2022'),
            'department' => User::DEPARTMENT_PRESCHOOL,
            'status' => AcademicYear::STATUS_ENROLLMENT
        ]);

        AcademicYear::create([
            'name' => env('SP_SCHOOL_YEAR', '2021-2022'),
            'department' => User::DEPARTMENT_ELEMENTARY,
            'status' => AcademicYear::STATUS_ENROLLMENT
        ]);

        AcademicYear::create([
            'name' => env('SP_SCHOOL_YEAR', '2021-2022'),
            'department' => User::DEPARTMENT_JUNIOR_HIGH,
            'status' => AcademicYear::STATUS_ENROLLMENT
        ]);

        AcademicYear::create([
            'name' => env('SP_SCHOOL_YEAR', '2021-2022'),
            'department' => User::DEPARTMENT_SENIOR_HIGH,
            'status' => AcademicYear::STATUS_ENROLLMENT
        ]);
    }
}
