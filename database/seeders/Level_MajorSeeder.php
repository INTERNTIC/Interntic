<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Level_MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level_majors=[
            [
                'major_id'=>1,
                'level_id' => 1,
            ],
            [
                'major_id'=>1,
                'level_id' =>2,
            ],
            [
                'major_id'=>2,
                'level_id' =>3,
            ],
        ];
       
        foreach ($level_majors as $level_major) {
            DB::table('level_major')->insert([
                'major_id' =>$level_major['major_id'] ,
                'level_id' =>$level_major['level_id'] ,
            ]);
     
        }
    }
}
