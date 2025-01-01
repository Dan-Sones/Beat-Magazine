<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Services\JournalistService;
use S246109\BeatMagazine\Services\SessionService;

class UpgradeController
{
    private JournalistService $journalistService;
    private SessionService $sessionService;

    /**
     * @param JournalistService $journalistService
     * @param SessionService $sessionService
     */
    public function __construct(JournalistService $journalistService, SessionService $sessionService)
    {
        $this->journalistService = $journalistService;
        $this->sessionService = $sessionService;
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        if ($this->sessionService->isJournalist()) {
            return $response->withHeader('Location', '/albums')->withStatus(302);
        }

        if ($this->sessionService->getUsername() === null) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/upgrade.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

    public function upgrade(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if ($this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        $userId = $this->sessionService->getUserID();
        if ($userId === null) {
            return $response->withStatus(400);
        }

        $validatePassword = $this->journalistService->validateUpgradePassword($request->getParsedBody()['password']);

        if (!$validatePassword) {
            return $response->withStatus(400);
        }

        $this->journalistService->upgradeUser($userId);
        $this->sessionService->set('role', 'journalist');

        return $response->withStatus(200);
    }
}