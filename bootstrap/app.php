<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustHosts(['127.0.0.1','localhost']);
        $middleware->trustProxies(['*']);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function ($response) {
            if ($response->getStatusCode() === 403 || $response->getStatusCode() === 401) {
                return back()->error('messages.sin_permisos');
            }
            if ($response->getStatusCode() === 419) {
                return back()->error('messages.pagina_expirada');
            }
            if ($response->getStatusCode() === 429) {
                return back()->withErrors(['email' => __('auth.throttle')]);
            }

            return $response;
        });
    })->create();
