<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\AlbumsController;
use S246109\BeatMagazine\Controllers\ArtistController;
use S246109\BeatMagazine\Controllers\HomeController;
use S246109\BeatMagazine\Controllers\LoginController;
use S246109\BeatMagazine\Controllers\PasswordResetController;
use S246109\BeatMagazine\Controllers\ProfileController;
use S246109\BeatMagazine\Controllers\RegisterController;
use S246109\BeatMagazine\Controllers\UpgradeController;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ':index');

    $app->get('/register', RegisterController::class . ':index');

    $app->get('/login', LoginController::class . ':index');

    $app->get('/albums', AlbumsController::class . ':index');

    $app->get('/artist/{artistName}', ArtistController::class . ':show');

    $app->get('/artist/{artistName}/{albumName}', AlbumController::class . ':show');

    $app->get('/user/{username}', ProfileController::class . ':show');

    $app->get('/upgrade', UpgradeController::class . ':index');

    $app->get('/reset-password', PasswordResetController::class . ':index');
};