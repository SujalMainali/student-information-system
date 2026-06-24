<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Course;
use App\Models\Student;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 courses
        $courses = Course::factory()->count(10)->create();

        // Create 50 students
        $students = Student::factory()->count(50)->create();

        // Enroll each student in 1 to 3 random courses
        foreach ($students as $student) {
            $randomCourses = $courses->random(rand(1, 3));
            $enrolledAt = now()->subDays(rand(0, 1000));

            $student->courses()->attach($randomCourses, [
                'enrolled_at' => $enrolledAt,
                'created_at' => $enrolledAt,
                'updated_at' => $enrolledAt,
            ]);
        }
    }
}
