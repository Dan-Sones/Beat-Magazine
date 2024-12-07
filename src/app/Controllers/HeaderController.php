<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HeaderController
{

    public function index(): string
    {
        $authenticated = $_SESSION['authenticated'] ?? false;
        $username = $_SESSION['username'] ?? null;


        ob_start();
        include __DIR__ . '/../../public/includes/header.php';
        return ob_get_clean(); // Return the captured output
    }

}