<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $majors=[
            [
                'name' => 'Math et informatique',
                'short_cut'=>'MI',
                'department_id'=>1
            ],
            [
                'name' => "Technologie de l'information",
                'short_cut'=>'TI',
                'department_id'=>2
            ],
        ];
       
        foreach ($majors as $major) {
            DB::table('majors')->insert([
                'name' =>$major['name'] ,
                'short_cut' =>$major['short_cut'] ,
                'department_id' =>$major['department_id'] ,
            ]);
     
        }

    }
}
