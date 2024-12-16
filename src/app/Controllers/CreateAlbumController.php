<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateAlbumController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        ob_start();
        include PRIVATE_PATH . '/src/app/Views/createAlbum.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}