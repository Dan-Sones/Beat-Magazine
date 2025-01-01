<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Services\SessionService;

class HeaderController
{
    private SessionService $sessionService;

    /**
     * @param SessionService $sessionService
     */
    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }


    public function index(): string
    {
        $authenticated = $this->sessionService->isAuthenticated();
        $username = $_SESSION['username'] ?? null;

        ob_start();
        include PUBLIC_PATH . '/includes/header.php';
        return ob_get_clean();
    }

    public function logout(Request $request, Response $response, array $args): Response
    {
        $this->sessionService->logout();
        return $response->withStatus(200);
    }
}