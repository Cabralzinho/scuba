<?php

namespace App\Config;

use App\Exceptions\InvalidBodyFieldException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Throwable;

class ErrorHandler {
    private $app;

    public function __construct(App $app) {
        $this->app = $app;
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
    ): Response {
        $path = $request->getUri()->getPath();

        if (str_starts_with($path, "/api")) {
            return $this->handleApiError($request, $exception);
        }

        return $this->handleFrontendError($request, $exception);
    }

    private function handleApiError(
        Request $request,
        Throwable $exception,
    ): Response {
        $response = $this->app->getResponseFactory()->createResponse();

        if ($exception instanceof InvalidBodyFieldException) {
            $response->getBody()->write(json_encode(
                ["message" => $exception->error]
            ));

            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(400);
        }

        $response->getBody()->write(json_encode(
            ["message" => $exception->getMessage()]
        ));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(500);
    }

    private function handleFrontendError(
        Request $request,
        Throwable $exception,
    ): Response {
        $response = $this->app->getResponseFactory()->createResponse();

        return $response;
    }
}
