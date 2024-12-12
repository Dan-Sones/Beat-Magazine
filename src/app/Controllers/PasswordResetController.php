<?php

namespace S246109\BeatMagazine\Controllers;

use PDO;
use S246109\BeatMagazine\Models\User;
use S246109\BeatMagazine\Services\UserService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PasswordResetController
{

    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index(Request $request, Response $response, array $args): Response
    {
        ob_start();
        include PRIVATE_PATH . '/src/app/Views/passwordReset.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

    public function handleResetRequest(Request $request, Response $response, array $args): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['email'])) {
            return $response->withStatus(400);
        }

        if (!$this->userService->isEmailTaken($data['email'])) {
            return $response->withStatus(404);
        }

        $email = $data['email'];

        $success = $this->userService->handlePasswordResetRequest($email);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }


}