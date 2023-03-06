<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student_accounts=[
            [
                'id'=>'1',
                'email' => 'omar.goumgoum@univ-constantine2.dz',
                'password'=>'$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
                'email_verified' => 1,
            ],
            [
                'id'=>'2',
                'email' => 'lokmane.abdessalam@univ-constantine2.dz',
                'password'=>'$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
                'email_verified' => 1,
             
            ],
        ];
       
        foreach ($student_accounts as $student_account) {
            DB::table('student_accounts')->insert([
                'id' =>$student_account['id'],
                'email' =>$student_account['email'] ,
                'password' =>$student_account['password'],
                'email_verified' =>$student_account['email_verified'],
            ]);
     
        }
    }
}
