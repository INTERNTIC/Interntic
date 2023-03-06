<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InternshipResponsibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internship_responsibles=[
            [
                "first_name"=>"omar",
                "last_name"=>"goumgoum",
                "email"=>"omar.goumgoum@univ-constantine2.dz",
                "password"=>'$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
                "phone"=>"000000000",
                "company_id"=>"1",
                
            ],
            [
                "first_name"=>"lokmane",
                "last_name"=>"abdessalam",
                "email"=>"lokmane.abdessalam@univ-constantine2.dz",
                "password"=>'$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
                "phone"=>"000000001",
                "company_id"=>"2",
            ],
           
        ];
       
        foreach ($internship_responsibles as $internship_responsible) {
            DB::table('internship_responsibles')->insert([
                "first_name"=>$internship_responsible['first_name'],
                "last_name"=>$internship_responsible['last_name'],
                "email"=>$internship_responsible['email'],
                "password"=>$internship_responsible['password'],
                "phone"=>$internship_responsible['phone'],
                "company_id"=>$internship_responsible['company_id'],
            ]);
     
        }
    }
}
