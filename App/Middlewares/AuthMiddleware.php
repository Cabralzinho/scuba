<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        $response = new Response();

        $onlyUnAuthenticatedPaths = [
            "/login",
            "/register",
            "/forget_password"
        ];

        if (!isset($_SESSION["user"])) {
            return $response
                ->withHeader("Location", "/login")
                ->withStatus(302);
        }

        $isAuthenticatedPath = in_array($request->getUri()->getPath(), $onlyUnAuthenticatedPaths);

        if ($isAuthenticatedPath) {
            return $response
                ->withHeader("Location", "/")
                ->withStatus(302);
        }

        return $handler->handle($request);
    }
}
