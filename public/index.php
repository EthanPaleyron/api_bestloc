<?php
require_once '../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Controller\BillingController;
use App\Controller\ContractController;
use App\Controller\CustomerController;
use App\Controller\VehiculeController;
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

$billingController = new BillingController();
// Routes billings
$app->get('/billings/{id}', [$billingController, 'getById']);
$app->get('/billings', [$billingController, 'getAll']);
$app->post('/billings', [$billingController, 'create']);
$app->put('/billings/{id}', [$billingController, 'update']);
$app->delete('/billings/{id}', [$billingController, 'delete']);

$contractController = new ContractController();
// Routes contracts
$app->get('/contracts/{id}', [$contractController, 'getById']);
$app->get('/contracts', [$contractController, 'getAll']);
$app->post('/contracts', [$contractController, 'create']);
$app->put('/contracts/{id}', [$contractController, 'update']);
$app->delete('/contracts/{id}', [$contractController, 'delete']);

$customerController = new CustomerController();
// Routes customers
$app->get('/customers/{id}', [$customerController, 'getById']);
$app->get('/customers', [$customerController, 'getAll']);
$app->post('/customers', [$customerController, 'create']);
$app->put('/customers/{id}', [$customerController, 'update']);
$app->delete('/customers/{id}', [$customerController, 'delete']);

$vehiculesController = new VehiculeController();
// Routes vehicules
$app->get('/vehicules/{id}', [$vehiculesController, 'getById']);
$app->get('/vehicules', [$vehiculesController, 'getAll']);
$app->post('/vehicules', [$vehiculesController, 'create']);
$app->put('/vehicules/{id}', [$vehiculesController, 'update']);
$app->delete('/vehicules/{id}', [$vehiculesController, 'delete']);
$app->run();