<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Age;

class AgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ages = [
            '4 Years old',
            '5 Years old',
            '6 Years old',
        ];

        foreach($ages as $age){
            Age::create(['name' => $age]);
        }
    }
}
