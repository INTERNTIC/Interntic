<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department_heads = [
            [
                "first_name" => "omar",
                "last_name" => "goumgoum",
                "email" => "omar.goumgoum@univ-constantine2.dz",
                "password" => '$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
                "department_id" => "1",

            ],
            [
                "first_name" => "lokmane",
                "last_name" => "abdessalam",
                "email" => "lokmane.abdessalam@univ-constantine2.dz",
                "password" => '$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
                "department_id" => "2",
            ],

        ];

        foreach ($department_heads as $department_head) {
            DB::table('department_heads')->insert([
                "first_name" => $department_head['first_name'],
                "last_name" => $department_head['last_name'],
                "email" => $department_head['email'],
                "password" => $department_head['password'],
                "department_id" => $department_head['department_id'],
            ]);
        }
    }
}
