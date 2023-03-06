<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [
            [
                "first_name" => "omar",
                "last_name" => "goumgoum",
                "birthday" => "2002/04/16",
                "place_of_birth" => "ghardaia",
                "phone" => "0000000000",
                "student_card" => "0000000000",
                "social_security_num" => "0000000000",
                "level_major_id" => "3"
            ],
            [
                "first_name" => "lokmane",
                "last_name" => "abdessalam",
                "birthday" => "2002/02/05",
                "place_of_birth" => "ghardaia",
                "phone" => "0000000001",
                "student_card" => "0000000001",
                "social_security_num" => "0000000001",
                "level_major_id" => "3"
            ],
        ];

        foreach ($students as $student) {
            DB::table('students')->insert([
                "first_name" => $student['first_name'],
                "last_name" => $student['last_name'],
                "birthday" => $student['birthday'],
                "place_of_birth" => $student['place_of_birth'],
                "phone" => $student['phone'],
                "student_card" => $student['student_card'],
                "social_security_num" => $student['social_security_num'],
                "level_major_id" => $student['level_major_id'],
            ]);
        }
    }
}
