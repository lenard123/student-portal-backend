<?php

namespace Database\Seeders;

use App\Models\Enrollee;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    private $id = null;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = Section::all();
        $sections->each(function ($section) {
            $students = User::factory()->student()->count(20)->create()->map(function ($student) use ($section) {
                $enrolee = [];
                $enrolee['transaction_id'] = $this->getId();
                $enrolee['student_id'] = $student->id;
                $enrolee['section_id'] = $section->id;
                $enrolee['academic_year_id'] = $section->academic_year_id;
                $enrolee['grade_level_id'] = $section->grade_level_id;
                $enrolee['status'] = Enrollee::STATUS_ENROLLED;
                return $enrolee;
            });
            Enrollee::insert($students->toArray());
        });
    }

    private function getId()
    {
        if ($this->id == null)
            $this->id = time();
        else
            $this->id++;
        return "TRN" . $this->id;
    }
}
