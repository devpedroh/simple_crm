<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth:sanctum' => [
                EnsureFrontendRequestsAreStateful::class,
                \Illuminate\Auth\Middleware\Authenticate::class,
            ]
        ]);
    })
    ->withBindings([
        \App\Repositories\Contracts\Auth\AuthLoginRepositoryInterface::class => \App\Repositories\Eloquent\Auth\AuthLoginRepository::class,
        \App\Repositories\Contracts\Auth\AuthRegisterRepositoryInterface::class => \App\Repositories\Eloquent\Auth\AuthRegisterRepository::class,

        \App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsUnitRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\Utils\DashboardUtilsUnitRepository::class,
        \App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsPaymentMethodRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\Utils\DashboardUtilsPaymentMethodRepository::class,
        \App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsPaymentTypeRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\Utils\DashboardUtilsPaymentTypeRepository::class,

        \App\Repositories\Contracts\Dashboard\DashboardClientRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\DashboardClientRepository::class,
        \App\Repositories\Contracts\Dashboard\DashboardSupplierRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\DashboardSupplierRepository::class,
        \App\Repositories\Contracts\Dashboard\DashboardProductRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\DashboardProductRepository::class,
        \App\Repositories\Contracts\Dashboard\DashboardSellRepositoryInterface::class => \App\Repositories\Eloquent\Dashboard\DashboardSellRepository::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, $request) {
            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'code' => 401,
                    'type' => 'Unauthorized',
                    'message' => 'Você precisa estar autenticado para acessar esta rota.',
                ], 401);
            }

            return response()->json([
                'code' => $exception->getCode() ?: 500,
                'type' => get_class($exception),
                'message' => $exception->getMessage(),
            ], 500);
        });
    })->create();
