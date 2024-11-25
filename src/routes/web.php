<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\AlbumsController;

return function ($app) {
    $app->get('/', function ($request, $response) {
        require_once __DIR__ . '/../app/Controllers/HomeController.php';
        $controller = new HomeController();
        return $controller->index($request, $response);
    });

    $app->get('/albums', function ($request, $response) {
        require_once __DIR__ . '/../app/Controllers/AlbumsController.php';
        $controller = new AlbumsController();
        return $controller->index($request, $response);
    });

    $app->get('/album/{artistName}/{albumName}', function ($request, $response, $args) use ($app) {
        require_once __DIR__ . '/../app/Controllers/AlbumController.php';
        $albumFactory = $app->getContainer()->get(\S246109\BeatMagazine\Factories\AlbumFactory::class);
        $controller = new AlbumController($albumFactory);
        return $controller->show($request, $response, $args);
    });
};