<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'courses.browse',
            'enrollment-requests.create',
            'enrollment-requests.view-own',
            'enrollment-requests.view-all',
            'enrollment-requests.approve',
            'enrollment-requests.reject',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $admin = Role::findOrCreate('admin');
        $staff = Role::findOrCreate('staff');
        $student = Role::findOrCreate('student');

        $admin->givePermissionTo([
            'courses.browse',
            'enrollment-requests.view-all',
            'enrollment-requests.approve',
            'enrollment-requests.reject',
        ]);

        $staff->givePermissionTo([
            'courses.browse',
            'enrollment-requests.view-all',
        ]);

        $student->givePermissionTo([
            'courses.browse',
            'enrollment-requests.create',
            'enrollment-requests.view-own',
        ]);
    }

}
