<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GradeLevelSeeder::class,
            SubjectSeeder::class,
            AcademicYearSeeder::class,
            AcademicYearCurriculumSeeder::class,
            FeesSeeder::class,
            SectionSeeder::class,
            FacultySeeder::class,
            ScheduleSeeder::class,
            StudentSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
