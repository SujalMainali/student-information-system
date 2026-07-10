<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionNames = [
            // Dashboard
            'dashboard.view',

            // Manage
            'manage.view',

            // Profile
            'profile.view',
            'profile.update',

            // Students
            'students.view',
            'students.create',
            'students.update',
            'students.delete',
            'students.assign-courses',

            // Courses
            'courses.view',
            'courses.create',
            'courses.update',
            'courses.delete',
            'courses.enroll',

            // Enrollment Requests
            'enrollment-requests.create',
            'enrollment-requests.view-own',
            'enrollment-requests.view-all',
            'enrollment-requests.approve',
            'enrollment-requests.reject',

            // Notifications
            'notifications.view',
            'notifications.mark-read',
            'notifications.mark-all-read',

            // Users / Roles
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.assign-role',
            'roles.manage',
        ];

        $permissions = collect();

        foreach ($permissionNames as $permission) {
            $permissions->push(Permission::findOrCreate($permission, 'web'));
        }

        $admin = Role::findOrCreate('admin', 'web');
        $staff = Role::findOrCreate('staff', 'web');
        $student = Role::findOrCreate('student', 'web');
        
        $admin->givePermissionTo(
            $permissions->whereIn('name', [
                'dashboard.view',
                'manage.view',
                'profile.view',
                'profile.update',
                'students.view',
                'students.create',
                'students.update',
                'students.delete',
                'students.assign-courses',
                'courses.view',
                'courses.create',
                'courses.update',
                'courses.delete',
                'courses.enroll',
                'enrollment-requests.view-all',
                'enrollment-requests.approve',
                'enrollment-requests.reject',
                'notifications.view',
                'notifications.mark-read',
                'notifications.mark-all-read',
                'users.view',
                'users.create',
                'users.update',
                'users.delete',
                'users.assign-role',
                'roles.manage',
            ])->values()
        );

        $staff->givePermissionTo(
            $permissions->whereIn('name', [
                'dashboard.view',
                'profile.view',
                'profile.update',
                'students.view',
                'courses.view',
                'courses.update',
                'enrollment-requests.view-all',
                'notifications.view',
                'notifications.mark-read',
                'manage.view',
            ])->values()
        );

        $student->givePermissionTo(
            $permissions->whereIn('name', [
                'dashboard.view',
                'profile.view',
                'profile.update',
                'courses.view',
                'courses.enroll',
                'enrollment-requests.create',
                'enrollment-requests.view-own',
                'notifications.view',
                'notifications.mark-read',
            ])->values()
        );

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}