<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Race;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $races = [
            'Malay',
            'Chinese',
            'Indian',
            'Native',
            'Others'
        ];

        foreach($races as $race){
            Race::create(['name' => $race]);
        }
    }
}
