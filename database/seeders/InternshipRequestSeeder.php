<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternshipRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internship_requests = [
            [
                'student_id' => 1,
                'internshipResponsible_email' => "abdlokman123@gmail.com",
                'theme' => "theme 1",
                'start_at' => "2022-12-12",
                'end_at' => "2023-01-12",
                'company_id'=>1

            ],
            [
                'student_id' => 2,
                'internshipResponsible_email' => "abdlokman123@gmail.com",
                'theme' => "theme 2",
                'start_at' => "2022-2-2",
                'end_at' => "2023-3-12",
                'company_id'=>2],

        ];

        foreach ($internship_requests as $internship_request) {
            DB::table('internship_requests')->insert([
                "student_id" => $internship_request['student_id'],
                "internshipResponsible_email" => $internship_request['internshipResponsible_email'],
                "theme" => $internship_request['theme'],
                "start_at" => $internship_request['start_at'],
                "end_at" => $internship_request['end_at'],
                "company_id" => $internship_request['company_id'],
            ]);
        }
    }
}
