<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\Services\SessionService;
use S246109\BeatMagazine\Services\UserService;

class LoginController
{
    private UserService $userService;
    private UserFactory $userFactory;
    private SessionService $sessionService;

    /**
     * @param UserService $userService
     * @param UserFactory $userFactory
     * @param SessionService $sessionService
     */
    public function __construct(UserService $userService, UserFactory $userFactory, SessionService $sessionService)
    {
        $this->userService = $userService;
        $this->userFactory = $userFactory;
        $this->sessionService = $sessionService;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['email']) || !isset($data['password'])) {
            $response->getBody()->write(json_encode(['error' => 'Email and password are required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $email = $data['email'];
        $password = $data['password'];

        $user = $this->userFactory->getUserByEmailAddress($email);

        if ($user === null) {
            $response->getBody()->write(json_encode(['error' => 'User not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
        }

        if (!password_verify($password, $user->getPassword())) {
            $response->getBody()->write(json_encode(['error' => 'Invalid username or password']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $this->sessionService->startSession();
        $this->sessionService->set('user_id', $user->getId());
        $this->sessionService->set('otp_pending', true);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function verifyOTP(Request $request, Response $response, array $args): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!$this->sessionService->get('otp_pending')) {
            return $response->withStatus(401);
        }

        if (!isset($data['otp'])) {
            return $response->withStatus(400);
        }

        $userId = $this->sessionService->getUserID();
        if ($userId === null) {
            return $response->withStatus(500);
        }

        $otp = $data['otp'];

        if (!$this->userService->validateOTP($userId, $otp)) {
            return $response->withStatus(401);
        }

        $user = $this->userFactory->getUserById($userId);

        $this->sessionService->set('otp_pending', false);
        $this->sessionService->set('authenticated', true);
        $this->sessionService->set('username', $user->getUsername());
        $this->sessionService->set('role', $user->getRole());

        $response->getBody()->write(json_encode(['valid' => true]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        if ($this->sessionService->isAuthenticated()) {
            return $response->withHeader('Location', '/albums')->withStatus(302);
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/login.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }
}