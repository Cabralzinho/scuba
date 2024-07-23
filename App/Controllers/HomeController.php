<?php

namespace App\Controllers;

use App\TemplateEngine;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController {
    public function index(Request $request, Response $response): Response {
        $page = (new TemplateEngine())->render("home");

        $response->getBody()->write($page);
        $response->withStatus(200);

        return $response;
    }
}