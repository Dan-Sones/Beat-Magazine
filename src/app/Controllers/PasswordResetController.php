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
        $token = $request->getQueryParams()['token'] ?? null;
        if ($token === null) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $validToken = $this->userService->checkIfValidResetToken($token);

        if (!$validToken) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

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

    public function resetPassword(Request $request, Response $response, array $args): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['new_password']) || !isset($data['token']) || !isset($data['otp'])) {
            return $response->withStatus(400);
        }

        $userID = $this->userService->getUserIDFromResetToken($data['token']);

        if (!$this->userService->validateOTP($userID, $data['otp'])) {
            return $response->withStatus(401);
        }

        $success = null;

        try {
            $success = $this->userService->resetPassword($data['token'], $data['new_password']);
        } catch (\Exception $e) {
            return $response->withStatus(500);
        }

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }


}