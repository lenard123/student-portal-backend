<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = Section::all();
        $sections->each(function ($section) {
            $subjects = $section->gradeLevel->subjects;
            $subjects->each(function ($subject) use ($section) {
                $section->schedules()->create([
                    'subject_id' => $subject->id,
                    'faculty_id' => User::query()
                        ->where('role', User::ROLE_FACULTY)
                        ->where('department', $section->gradeLevel->department)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'schedules' => []
                ]);
            });
        });
    }
}
