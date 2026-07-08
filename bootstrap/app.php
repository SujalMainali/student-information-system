<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
        then: function (): void {
            Route::middleware(['web', 'auth'])
                ->name('course.')
                ->group(base_path('routes/course.php'));

            Route::middleware(['web', 'auth'])
                ->name('student.')
                ->group(base_path('routes/student.php'));

            Route::middleware('web')
                ->name('auth.')
                ->prefix('auth')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(
            fn (Request $request) => route('auth.login')
        );

        $middleware->redirectUsersTo(
            fn (Request $request) => route('dashboard')
        );

        $middleware->alias([
            'role' => App\Http\Middleware\RoleMiddleware::class,
            'permission' => App\Http\Middleware\PermissionMiddleware::class,
            'role_or_permission' => App\Http\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
