<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\InternshipRequestSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            MajorSeeder::class,
            LevelSeeder::class,
            Level_MajorSeeder::class,
            StudentSeeder::class,
            StudentAccountSeeder::class,
            Super_adminSeeder::class,
            CompanySeeder::class,
            InternshipResponsibleSeeder::class,
            DepartmentHeadSeeder::class,
            InternshipRequestSeeder::class,
        ]);
    }
}
