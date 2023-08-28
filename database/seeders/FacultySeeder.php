<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $preschool = User::factory()->faculty()->department(User::DEPARTMENT_PRESCHOOL)->count(8)->create();
        // $preschool_subjects = Subject::whereHas('gradeLevel', fn ($q) => $q->where('department', User::DEPARTMENT_PRESCHOOL))->get();
        // $preschool->each(function ($faculty) use ($preschool_subjects) {
        //     $faculty->subjects()->attach($preschool_subjects->random(3)->pluck('id'));
        // });
        $this->generateSubject(User::DEPARTMENT_PRESCHOOL, 8);
        $this->generateSubject(User::DEPARTMENT_ELEMENTARY, 18);
        $this->generateSubject(User::DEPARTMENT_JUNIOR_HIGH, 15);
        $this->generateSubject(User::DEPARTMENT_SENIOR_HIGH, 10);

        // User::factory()->faculty()->department(User::DEPARTMENT_ELEMENTARY)->count(18)->create();
        // User::factory()->faculty()->department(User::DEPARTMENT_JUNIOR_HIGH)->count(15)->create();
        // User::factory()->faculty()->department(User::DEPARTMENT_SENIOR_HIGH)->count(10)->create();

        // $faculties_id = User::query()
        //     ->where('role', User::ROLE_FACULTY)
        //     ->select('id', 'department')
        //     ->toArray();

    }

    private function generateSubject($department, $count)
    {
        $faculties = User::factory()->faculty()->department($department)->count($count)->create();
        $subjects = Subject::whereHas('gradeLevel', fn ($q) => $q->where('department', $department))->get();
        $faculties->each(function ($faculty) use ($subjects) {
            $faculty->toFaculty()->subjects()->attach($subjects->pluck('id'));
        });
    }
}
