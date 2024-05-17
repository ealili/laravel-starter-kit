<?php

use App\Exceptions\Generic\BadRequestException;
use App\Exceptions\Generic\DataNotFoundException;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {

            if ($e instanceof BadRequestException ||
                $e instanceof DataNotFoundException) {
                return new JsonResponse([
                    'data' => ['message' => $e->getMessage()],
                    'meta' => ['timestamp' => Carbon::now()],
                ], $e->getCode());
            }

            if ($e instanceof AuthenticationException) {
                return new JsonResponse([
                    'data' => ['message' => $e->getMessage()],
                    'meta' => ['timestamp' => Carbon::now()],
                ], ResponseAlias::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof AccessDeniedHttpException) {
                return new JsonResponse([
                    'data' => ['message' => $e->getMessage()],
                    'meta' => ['timestamp' => Carbon::now()],
                ], $e->getStatusCode());
            }

            if ($e instanceof ValidationException) {
                return new JsonResponse([
                    'data' => ['errors' => $e->errors()],
                    'meta' => ['timestamp' => Carbon::now()],
                ], $e->status);
            }

            return new JsonResponse([
                'data' => ['message' => $e->getMessage()],
                'meta' => ['timestamp' => Carbon::now()],
            ], 500);
        });
    })->create();


