<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            ['fee' => 'Miscellaneous Fee', 'amount' => 2500],
            ['fee' => 'Library Fee', 'amount' => 100],
            ['fee' => 'Computer', 'amount' => 300]
        ];

        $grade_levels = GradeLevel::all();
        $grade_levels->each(function ($grade_level) use ($fees) {
            foreach ($fees as $fee) {
                $grade_level->fees()->create($fee + [
                    'academic_year_id' => AcademicYear::getActiveAcademicYear($grade_level->department)->id,
                ]);
            }
        });
    }
}
