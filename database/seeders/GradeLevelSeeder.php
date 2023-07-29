<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradeLevel::insert([
            ['order' => 0, 'name' => 'Kinder', 'department' => User::DEPARTMENT_PRESCHOOL],
            ['order' => 1, 'name' => 'Grade 1', 'department' => User::DEPARTMENT_ELEMENTARY],
            ['order' => 2, 'name' => 'Grade 2', 'department' => User::DEPARTMENT_ELEMENTARY],
            ['order' => 3, 'name' => 'Grade 3', 'department' => User::DEPARTMENT_ELEMENTARY],
            ['order' => 4, 'name' => 'Grade 4', 'department' => User::DEPARTMENT_ELEMENTARY],
            ['order' => 5, 'name' => 'Grade 5', 'department' => User::DEPARTMENT_ELEMENTARY],
            ['order' => 6, 'name' => 'Grade 6', 'department' => User::DEPARTMENT_ELEMENTARY],
            ['order' => 7, 'name' => 'Grade 7', 'department' => User::DEPARTMENT_JUNIOR_HIGH],
            ['order' => 8, 'name' => 'Grade 8', 'department' => User::DEPARTMENT_JUNIOR_HIGH],
            ['order' => 9, 'name' => 'Grade 9', 'department' => User::DEPARTMENT_JUNIOR_HIGH],
            ['order' => 10, 'name' => 'Grade 10', 'department' => User::DEPARTMENT_JUNIOR_HIGH],
            ['order' => 11, 'name' => 'Grade 11', 'department' => User::DEPARTMENT_SENIOR_HIGH],
            ['order' => 12, 'name' => 'Grade 12', 'department' => User::DEPARTMENT_SENIOR_HIGH],
        ]);
    }
}
