<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@ukm.edu.my',
        ]);

        $user->assignRole('admin');

        $teacher = User::factory()->create([
            'name' => 'Puan Sarah',
            'email' => 'teacher@ukm.edu.my'
        ]);

        $teacher->assignRole('teacher');

        $parent = User::factory()->create([
            'name' => 'Puan Camelia',
            'email' => 'parent@ukm.edu.my'
        ]);

        $parent->assignRole('parent');
    }
}
