<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            'Bahasa Melayu',
            'English Language',
            'Mathematics',
            'Science',
        ];

        foreach($subjects as $subject){
            Subject::create(['name' => $subject]);
        }
    }
}
