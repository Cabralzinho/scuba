<?php

namespace App\Controllers;

use App\Dtos\LoginUserDto;
use App\Dtos\RegisterUserDto;
use App\Models\UserModel;
use App\Services\Auth\LoginService;
use App\Services\Auth\RegisterService;
use App\TemplateEngine;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController {
    public function showLoginPage(Request $request, Response $response): Response {
        $page = (new TemplateEngine())->render("login");

        $response->getBody()->write($page);
        $response->withStatus(200);

        return $response;
    }

    public function login(Request $request, Response $response): Response {
        $data = $request->getParsedBody();

        $loginDto = new LoginUserDto(
            $data["email"],
            $data["password"]
        );

        $service = new LoginService(new UserModel);
        $user = $service->login($loginDto);

        $_SESSION["user"] = $user;

        $response->getBody()->write(
            json_encode([
                "message" => "Login efetuado com sucesso.",
                "token" => session_id()
            ])
        );

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }

    public function showRegisterPage(Request $request, Response $response): Response {
        $page = (new TemplateEngine())->render("register");

        $response->getBody()->write($page);
        $response->withStatus(200);

        return $response
            ->withStatus(200);
    }

    public function register(Request $request, Response $response): Response {
        try {
            $data = $request->getParsedBody();

            $registerDto = new RegisterUserDto(
                $data["name"],
                $data["email"],
                $data["password"],
                $data["confirmPassword"]
            );

            $service = new RegisterService($registerDto);
            $service->register();

            $response->getBody()->write(
                json_encode([
                    "message" => "Usuário criado com sucesso."
                ])
            );

            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                "message" => $e->getMessage()
            ]));

            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(400);
        }
    }

    public static function showForgetPasswordPage(Request $request, Response $response): Response {
        $page = (new TemplateEngine())->render("forget_password");

        $response->getBody()->write($page);
        $response->withStatus(200);

        return $response;
    }
}
