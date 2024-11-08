<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\AlbumsController;

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require_once __DIR__ . '/../app/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    case '/albums' :
        require_once __DIR__ . '/../app/Controllers/AlbumsController.php';
        $controller = new AlbumsController();
        $controller->index();
        break;
    case '/album' :
        require_once __DIR__ . '/../app/Controllers/AlbumController.php';
        $controller = new AlbumController();
        $controller->index();
        break;
    default:
        http_response_code(404);
        echo 'Page not found';
        break;
}