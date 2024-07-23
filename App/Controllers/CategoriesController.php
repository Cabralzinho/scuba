<?php

namespace App\Controllers;

use App\TemplateEngine;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriesController {
    public function showAddCategoryPage(Request $request, Response $response): Response {
        $page = (new TemplateEngine())->render("add-category");

        $response->getBody()->write($page);

        return $response
            ->withStatus(200);
    }
}
