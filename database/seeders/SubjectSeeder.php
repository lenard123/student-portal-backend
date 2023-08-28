<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade_levels = GradeLevel::all();
        $grade_school_subjects = [
            User::DEPARTMENT_PRESCHOOL => [
                "Values",
                "Physical Education",
                "Arts",
                "Math",
                "Mother Tongue",
            ],
            User::DEPARTMENT_ELEMENTARY => [
                "Mother Tongue",
                "Filipino",
                "English",
                "Mathematics",
                "Science",
                "Araling Panlipunan",
                "Edukasyon sa Pagpapakatao",
                "Music",
                "Arts",
                "Physical Education",
                "Health",
                "Edukasyong Pantahanan at Pangkabuhayan",
                "Technology and Livelihood Education",
            ],
            User::DEPARTMENT_JUNIOR_HIGH => [
                "Mother Tongue",
                "Filipino",
                "English",
                "Mathematics",
                "Science",
                "Araling Panlipunan",
                "Edukasyon sa Pagpapakatao",
                "Music",
                "Arts",
                "Physical Education",
                "Health",
                "Edukasyong Pantahanan at Pangkabuhayan",
                "Technology and Livelihood Education",
            ],
            User::DEPARTMENT_SENIOR_HIGH => [
                "Oral Communication",
                "Reading and Writing",
                "Komunikasyon at pananaliksik sa wika at kulturang Filipino",
                "21st century literature from the Philippines and the world",
                "Contemporary Philippine arts from the regions",
                "Media and information literacy",
                "General Mathematics",
                "Statistics and Probability",
                "Earth and Life Sciences",
                "Physical Science",
                "Introduction to philosophy of the human person/Pambungad sa pilosopiya ng tao",
                "Physical education and health",
            ]
        ];

        $grade_levels->each(function ($grade_level) use ($grade_school_subjects) {
            collect($grade_school_subjects[$grade_level->department])->each(function ($subject) use ($grade_level) {
                Subject::create([
                    'name' => $subject,
                    'grade_level_id' => $grade_level->id,
                ]);
            });
        });
    }
}
