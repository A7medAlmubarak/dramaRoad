<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Moderator;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([ //1
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin1',
            'password' => bcrypt('123456789'),
            'phone' =>'001',
            'gender_id' => 1,
            'role_id'=>1
        ]);
        User::create([//2
            'name' => 'mod',
            'email' => 'mod@gmail.com',
            'username' => 'mod1',
            'password' => bcrypt('123456789'),
            'phone' =>'001',
            'gender_id' => 1,
            'role_id'=>2
        ]);



        Moderator::create([
            'user_id' => 2,
            'employment_date'=> Carbon::now(),
            'employment_date'=> Carbon::now(),
            'salary'=> 2000000,
            'vacations'=> 2
        ]);

        User::create([//3
            'name' => 'teacher',
            'email' => 'teacher@gmail.com',
            'username' => 'tech1',
            'phone' =>'001',
            'password' => bcrypt('123456789'),
            'gender_id' => 1,
            'role_id'=>3
        ]);

        Teacher::create([
            'user_id' => 3,
            'date'=> Carbon::now(),
            'creator_id'=>1

        ]);

        User::create([//4
            'name' => 'student',
            'email' => 'student@gmail.com',
            'username' => 'stu1',
            'phone' =>'001',
            'password' => bcrypt('123456789'),
            'gender_id' => 1,
            'role_id'=>4
        ]);

        Student::create([
            'user_id' => 4,
            'joining_date'=> Carbon::now(),
        ]);

        User::create([//5
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'username' => 'user1',
            'phone' =>'001',
            'password' => bcrypt('123456789'),
            'gender_id' => 1,
            'role_id'=>5
        ]);

        User::create([//6
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'username' => 'user2',
            'phone' =>'001',
            'password' => bcrypt('123456789'),
            'gender_id' => 2,
            'role_id'=>5
        ]);
    }
}
