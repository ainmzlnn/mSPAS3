<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $adminPermissions = [
            'register_parent',
            'register_teacher',
            'update_parent',
            'update_teacher',
            'view_student',
            'insert_academic_module'
        ];

        foreach ($adminPermissions as $permission) {
            $permission = Permission::create([
                'name' => $permission
            ]);
            $adminRole->givePermissionTo($permission);
        }

        $teacherRole = Role::create(['name' => 'teacher']);
        $teacherPermissions = [
            'add_homework',
            'download_uploaded_homework',
            'grade_homework',
            'grade_student',
            'generate_progress_report',
        ];

        foreach ($teacherPermissions as $permission) {
            $permission = Permission::create([
                'name' => $permission
            ]);
            $teacherRole->givePermissionTo($permission);
        }

        $parentRole = Role::create(['name' => 'parent']);
        $parentPermissions = [
            'edit_student',
            'view_homework',
            'view_progress_report',
            'view_grade',
        ];
    }
}
