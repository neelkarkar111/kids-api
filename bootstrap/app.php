<?php

use App\Helpers\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'active.child' => \App\Http\Middleware\RequireActiveChild::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {

        if (! $request->is('api/*')) {
            return null;
        }

        $previous = $e->getPrevious();

        // Model::findOrFail()
        if ($previous instanceof ModelNotFoundException) {
            return ApiResponse::error(
                class_basename($previous->getModel()) . ' not found.',
                404
            );
        }

        // Invalid API route
        return ApiResponse::error(
            'Route not found.',
            404   
        );
    });

    })->create();
