<?php
use DI\ContainerBuilder;
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../routes/web.php';

$containerBuilder = new ContainerBuilder();
$dependencies = require __DIR__ . '/../../config/dependencies.php';
$dependencies($containerBuilder);

try {
    $container = $containerBuilder->build();
} catch (Exception $e) {
    echo 'Error building container: ' . $e->getMessage();
    exit;
}

