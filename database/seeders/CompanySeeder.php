<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies=[
            [
                'name' => 'Amazon',
                'location'=>'USA',
            ],
            [
                'name' => "Microsoft",
                'location'=>'USA',
            ],
            [
                'name' => "Google",
                'location'=>'USA',
            ],
        ];
       
        foreach ($companies as $company) {
            DB::table('companies')->insert([
                'name' =>$company['name'] ,
                'location' =>$company['location'] ,
            ]);
     
        }
    }
}
