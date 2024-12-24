<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Services\JournalistService;
use S246109\BeatMagazine\Services\UserService;

class UpgradeController
{

    private JournalistService $journalistService;

    /**
     * @param JournalistService $journalistService
     */
    public function __construct(JournalistService $journalistService)
    {
        $this->journalistService = $journalistService;
    }


    public function index(Request $request, Response $response, array $args): Response
    {

        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] === 'journalist') {
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

    public function upgrade(Request $request, Response $response, array $args): Response
    {

        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) {
            return $response->withStatus(401);
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] === 'journalist') {
            return $response->withStatus(403);
        }

        if (!isset($_SESSION['user_id'])) {
            return $response->withStatus(400);
        }

        $validatePassword = $this->journalistService->validateUpgradePassword($request->getParsedBody()['password']);

        if (!$validatePassword) {
            return $response->withStatus(400);
        }

        $this->journalistService->upgradeUser($_SESSION['user_id']);

        $_SESSION['role'] = 'journalist';

        return $response->withStatus(200);
    }

}