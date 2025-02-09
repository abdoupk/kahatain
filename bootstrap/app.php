<?php

use App\Http\Middleware\TeamsPermissionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            $centralDomains = config('tenancy.central_domains');

            foreach ($centralDomains as $domain) {
                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/v1/web.php'));
            }

            Route::middleware('web')->group(base_path('routes/tenant.php'));

            Route::middleware('guest')->group(base_path('routes/v1/registration.php'));

            Route::middleware('api')->group(base_path('routes/v1/api.php'));
        },
        api: __DIR__.'/../routes/v1/api.php',
        commands: __DIR__.'/../routes/v1/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            TeamsPermissionMiddleware::class,
            App\Http\Middleware\HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (TenantCouldNotBeIdentifiedException $e, Request $request) {
            return Inertia::render('ErrorPage', ['status' => 400, 'tenantDontFound' => true])
                ->toResponse($request)
                ->setStatusCode(400);
        });

        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
                return Inertia::render('ErrorPage', ['status' => $response->getStatusCode()])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            } elseif ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => __('http-statuses.419'),
                ]);
            }

            return $response;
        });
    })->create();
