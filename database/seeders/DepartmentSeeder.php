<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments=[
            [
                'name' => 'tronc commun',
                'short_cut'=>'MI',
            ],
            [
                'name' => "IFA",
                'short_cut'=>'IFA',
            ],
        ];
       
        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'name' =>$department['name'] ,
                'short_cut' =>$department['short_cut'] ,
            ]);
     
        }
    }
}
