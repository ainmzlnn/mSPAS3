<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            '4 Orchid',
            '4 Sunflower',
            '4 Daisy',
            '5 Orchid',
            '5 Sunflower',
            '5 Daisy',
            '6 Orchid',
            '6 Sunflower',
            '6 Daisy',
        ];

        foreach ($classes  as $class) {
            Classes::create(['name' => $class]);
        }
    }
}
