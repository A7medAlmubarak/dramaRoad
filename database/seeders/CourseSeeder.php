<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create 10 courses
       for ($i = 1; $i <= 10; $i++) {
        $course = Course::create([
            'name' => "Course $i"
        ]);

        // For each course, create 5 levels
        for ($j = 1; $j <= 4; $j++) {
            $level = Level::create([
                'name' => "Level $j",
                'course_id' => $course->id
            ]);

            // For each level, create 3 subjects
            for ($k = 1; $k <= 5; $k++) {
                Subject::create([
                    'name' => "Subject $k",
                    'level_id' => $level->id
                ]);
            }
        }
    }
    }
}
