<?php

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;


$currentDir = realpath(__DIR__);

// if the directory two levels above currentDir is S246109-BeatMagazine then we are in a development environment
// otherwise we are in a production environment
if (basename(dirname($currentDir)) === 'S246109-BeatMagazine') {
    define('BASE_PATH', dirname(__DIR__));
    define('PUBLIC_PATH', BASE_PATH . '/public');
    define('PRIVATE_PATH', BASE_PATH);
} else {
    define('BASE_PATH', dirname(__DIR__));
    define('PUBLIC_PATH', BASE_PATH . '/httpdocs');
    define('PRIVATE_PATH', BASE_PATH . '/../private');
}


// Load Composer's autoloader
require_once PRIVATE_PATH . '/vendor/autoload.php';


$dotenv = Dotenv::createImmutable(PRIVATE_PATH);
$dotenv->load();

require_once PRIVATE_PATH . '/config/config.php';


$containerBuilder = new ContainerBuilder();
$dependencies = require PRIVATE_PATH . '/config/dependencies.php';
$dependencies($containerBuilder);
$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

session_start();

(require PRIVATE_PATH . '/src/routes/web.php')($app);
(require PRIVATE_PATH . '/src/routes/api.php')($app);


$app->run();