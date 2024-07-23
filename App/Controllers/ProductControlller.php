<?php

namespace App\Controllers;

use App\Dtos\AddProductDto;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Services\Categories\GetCategoriesService;
use App\Services\Products\AddProductService;
use App\Services\Products\GetProductsService;
use App\TemplateEngine;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductControlller {
    public function showProductsPage(Request $request, Response $response): Response {
        $service = new GetProductsService(new ProductModel);

        $products = $service->get()->toArray();

        $page = (new TemplateEngine())->render("products", ["products" => $products]);

        $response->getBody()->write($page);

        return $response
            ->withStatus(200);
    }

    // public function showProductsList(Request $request, Response $response): Response {
    //     $response->getBody()->write(
    //         json_encode($service->get())
    //     );

    //     return $response
    //         ->withHeader("Content-Type", "application/json")
    //         ->withStatus(200);
    // }

    public function showAddProductPage(Request $request, Response $response): Response {
        $service = new GetCategoriesService(new CategoryModel);

        $categories = $service->get();

        $page = (new TemplateEngine())->render("add-product", ["categories" => $categories]);

        $response->getBody()->write($page);

        return $response
            ->withStatus(200);
    }

    public function addProduct(Request $request, Response $response): Response {
        $data = $request->getParsedBody();

        $addDto = new AddProductDto(
            $data["name"],
            $data["description"],
            $data["price"],
            $request->getUploadedFiles()["images"]
        );

        $service = new AddProductService(new ProductModel);
        $product = $service->execute($addDto);

        $response->getBody()->write(
            json_encode(
                [
                    "message" => "Produto adicionado com sucesso.",
                    "id" => $product["id"]
                ]
            )
        );

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }
}
