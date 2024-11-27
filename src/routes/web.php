<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\AlbumsController;
use S246109\BeatMagazine\Controllers\ArtistController;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\ArtistFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;

return function ($app) {
    $app->get('/', function ($request, $response) {
        require_once __DIR__ . '/../app/Controllers/HomeController.php';
        $controller = new HomeController();
        return $controller->index($request, $response);
    });

    $app->get('/albums', function ($request, $response) use ($app) {
        require_once __DIR__ . '/../app/Controllers/AlbumsController.php';
        $albumFactory = $app->getContainer()->get(AlbumFactory::class);
        $controller = new AlbumsController($albumFactory);
        return $controller->index($request, $response);
    });

    $app->get('/artist/{artistName}', function ($request, $response, $args) use ($app) {
        require_once __DIR__ . '/../app/Controllers/AlbumController.php';
        $artistFactory = $app->getContainer()->get(ArtistFactory::class);
        $controller = new ArtistController($artistFactory);
        return $controller->show($request, $response, $args);
    });

    $app->get('/artist/{artistName}/{albumName:.+}', function ($request, $response, $args) use ($app) {
        require_once __DIR__ . '/../app/Controllers/AlbumController.php';
        $albumFactory = $app->getContainer()->get(AlbumFactory::class);
        $journalistReviewFactory = $app->getContainer()->get(JournalistReviewFactory::class);
        $controller = new AlbumController($albumFactory, $journalistReviewFactory);
        return $controller->show($request, $response, $args);
    });


};