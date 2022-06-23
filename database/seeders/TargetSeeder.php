<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Target;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $targets = [
            [ 'name' => 'Week 1', 'diff_days' => 7],
            [ 'name' => 'Week 2', 'diff_days' => 14],
            [ 'name' => 'Week 3', 'diff_days' => 21],
            [ 'name' => 'Week 4', 'diff_days' => 28],
        ];

        foreach($targets as $target){
            Target::create($target);
        }
    }
}
