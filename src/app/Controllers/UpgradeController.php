<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpgradeController
{

    public function index(Request $request, Response $response, array $args): Response
    {
        // Upgrade the account
        ob_start();
        include PRIVATE_PATH . '/src/app/Views/upgrade.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}