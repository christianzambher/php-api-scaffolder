<?php
use Slim\Factory\AppFactory;

ini_set('display_errors', 1);
session_start();
require __DIR__ . '/../../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('{{BasePath}}');
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
        
require __DIR__ . '/../rutas/rutas.php';
$app->run();