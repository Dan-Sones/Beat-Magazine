<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpgradeController
{

    public function index(Request $request, Response $response, array $args): Response
    {

        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        if ($_SESSION['role'] === 'journalist') {
            return $response->withHeader('Location', '/albums')->withStatus(302);
        }

        if (!isset($_SESSION['username'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }


        ob_start();
        include PRIVATE_PATH . '/src/app/Views/upgrade.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}