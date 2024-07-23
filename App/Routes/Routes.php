<?php

namespace App\Routes;

use App\Controllers\AuthController;
use App\Controllers\CategoriesController;
use App\Controllers\HomeController;
use App\Middlewares\AuthMiddleware;
use App\Controllers\ProductControlller;
use Slim\App;

class Routes {

    public function __construct(private App $app) {
        $this->app->addBodyParsingMiddleware();
    }

    private function startPagesRoutes() {
        $this->app->get("/", [HomeController::class, 'index'])->add(new AuthMiddleware());
        $this->app->get('/login', [AuthController::class, 'showLoginPage']);
        $this->app->get("/register", [AuthController::class, 'showRegisterPage']);
        $this->app->get("/forget_password", [AuthController::class, 'showForgetPasswordPage']);

        $this->app->group("/products", function ($app) {
            $app->get("", [ProductControlller::class, 'showProductsPage']);
            $app->get("/add-product", [ProductControlller::class, 'showAddProductPage']);
            $app->get("/add-category", [CategoriesController::class, 'showAddCategoryPage']);
        })->add(new AuthMiddleware());
    }

    private function startApiRoutes() {
        $this->app->group('/api', function ($app) {
            $app->group('/auth', function ($app) {
                $app->post('/login', [AuthController::class, 'login']);
                $app->post("/register", [AuthController::class, 'register']);
            });
            
            $app->group('/products', function ($app) {
                $app->post('', [ProductControlller::class, 'addProduct']);
            });
        });
    }

    public function startRoutes() {
        $this->startPagesRoutes();
        $this->startApiRoutes();
        $this->app->run();
    }
}
