<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            MajorSeeder::class,
            LevelSeeder::class,
            Level_MajorSeeder::class,
            StudentSeeder::class,
            StudentAccountSeeder::class,
            Super_adminSeeder::class,
            CompanySeeder::class,
            InternshipResponsibleSeeder::class,
            DepartmentSeeder::class,
            DepartmentHeadSeeder::class,
        ]);
    }
}
