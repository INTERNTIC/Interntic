<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels=[
            [
                'name' => 'L1'
            ],
            [
                'name' => "L1"
            ],
            [
                'name' => "L3"
            ],
            [
                'name' => "M1"
            ],
            [
                'name' => "M2"
            ],
        ];
       
        foreach ($levels as $level) {
            DB::table('levels')->insert([
                'name' =>$level['name'] ,
            ]);
     
        }
    }
}
