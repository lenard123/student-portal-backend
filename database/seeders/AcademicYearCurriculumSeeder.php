<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearCurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade_levels = GradeLevel::all();
        $grade_levels->each(function ($grade_level) {
            $subjects = Subject::where('grade_level_id', $grade_level->id)->get();
            $subjects->each(function ($subject) use ($grade_level) {
                DB::table('academic_year_curriculum')->insert([
                    'subject_id' => $subject->id,
                    'grade_level_id' => $grade_level->id,
                    'academic_year_id' => AcademicYear::getActiveAcademicYear($grade_level->department)->id,
                ]);
            });
        });
    }
}
