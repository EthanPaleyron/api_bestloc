<?php
require_once '../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Controller\CustomerController;
use Dotenv\Dotenv;

$app = AppFactory::create();
// Dossier racine
$app->setBasePath('/api');
// Parse json, form data and xml
$app->addBodyParsingMiddleware();
// Add the Slim built-in routing middleware
$app->addRoutingMiddleware();
// Handle exceptions
$app->addErrorMiddleware(true, true, true);
$customerController = new CustomerController();
// Routes
$app->get('/customers/{id}', [$customerController, 'getById']);
$app->get('/customers', [$customerController, 'getAll']);
$app->post('/customers', [$customerController, 'create']);
$app->put('/customers/{id}', [$customerController, 'update']);
$app->delete('/customers/{id}', [$customerController, 'delete']);
$app->run();