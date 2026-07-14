<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Spatie caches permissions, so we clear that cache for each test run.
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function signInWithPermissions(array $permissions = []): User
    {
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $user = User::factory()->create();

        if (! empty($permissions)) {
            $user->givePermissionTo($permissions);
        }

        $this->actingAs($user);

        return $user;
    }
}
