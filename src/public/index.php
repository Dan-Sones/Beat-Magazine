<?php

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$containerBuilder = new ContainerBuilder();
$dependencies = require __DIR__ . '/../../config/dependencies.php';
$dependencies($containerBuilder);
$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

(require __DIR__ . '/../routes/web.php')($app);
(require __DIR__ . '/../routes/api.php')($app);

$app->run();