<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterController
{
    public function index(Request $request, Response $response, array $args): Response
    {

        ob_start();
        include __DIR__ . '/../Views/register.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}