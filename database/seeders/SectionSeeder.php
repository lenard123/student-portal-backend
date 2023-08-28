<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = ['A', 'B', 'C'];
        $grade_levels = GradeLevel::all();
        $grade_levels->each(function ($grade_level) use ($sections) {
            foreach ($sections as $section) {
                $grade_level->sections()->create([
                    'name' => $grade_level->name . ' - ' . $section,
                    'academic_year_id' => AcademicYear::getActiveAcademicYear($grade_level->department)->id,
                ]);
            }
        });
    }
}
