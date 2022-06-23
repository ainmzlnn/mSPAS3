<?php

namespace Database\Seeders;

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
            GenderSeeder::class,
            RaceSeeder::class,
            ReligionSeeder::class,
            SubjectSeeder::class,
            AgeSeeder::class,
            TargetSeeder::class,
            ClassesSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            MonthSeeder::class,
        ]);
    }
}
