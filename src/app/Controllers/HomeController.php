<?php

namespace S246109\BeatMagazine\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        // Redirect to albums
        return $response->withHeader('Location', '/albums')->withStatus(302);
    }
}