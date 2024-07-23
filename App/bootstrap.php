<?php

date_default_timezone_set('America/Sao_Paulo');

require_once "../App/Config/Eloquent.php";

use App\Routes\Routes;
use Slim\Factory\AppFactory;
use App\Config\ErrorHandler;

session_start();

$app = AppFactory::create();
$errorHandler = new ErrorHandler($app);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

(new Routes($app))->startRoutes();