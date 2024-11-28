<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\AlbumsController;
use S246109\BeatMagazine\Controllers\ArtistController;
use S246109\BeatMagazine\Controllers\RegisterController;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ':index');

    $app->get('/register', RegisterController::class . ':index');

    $app->get('/albums', AlbumsController::class . ':index');

    $app->get('/artist/{artistName}', ArtistController::class . ':show');

    $app->get('/artist/{artistName}/{albumName:.+}', AlbumController::class . ':show');
};