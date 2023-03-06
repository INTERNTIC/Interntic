<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Super_adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('super_admins')->insert([
            'email' => 'super.admin@univ-constantine2.dz',
            'password' => '$2y$10$WkdXbwYkGy0/rB12ei0HQudKUMj50qjpFnytxljTki5cCtkXPKh8y',
        ]);
    }
}
