<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\Services\UserService;

class LoginController
{

    private userService $userService;

    private userFactory $userFactory;

    /**
     * @param UserService $userService
     * @param UserFactory $userFactory
     */
    public function __construct(UserService $userService, UserFactory $userFactory)
    {
        $this->userService = $userService;
        $this->userFactory = $userFactory;
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

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['username'] = $user->getUsername();
//        $_SESSION['firstName'] = $user->getFirstName();
//        $_SESSION['lastName'] = $user->getLastName();
//        $_SESSION['email'] = $user->getEmail();
//
//        //TODO: Come up with a better format for this and get it from the DB rather than hardcoding
//        $_SESSION['role'] = 'COMMUNITY-USER';

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['otp_pending'] = true;

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function verifyOTP(Request $request, Response $response, array $args): Response
    {

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($_SESSION['otp_pending']) || $_SESSION['otp_pending'] !== true) {
            return $response->withStatus(401);
        }


        if (!isset($data['otp'])) {
            return $response->withStatus(400);
        }

        if (!isset($_SESSION['user_id'])) {
            return $response->withStatus(500);
        }

        $otp = $data['otp'];

        $secret = $this->userService->getGoogle2fa_secretForUser($_SESSION['user_id']);

        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());

        if (!$tfa->verifyCode($secret, $otp)) {
            return $response->withStatus(401);
        }

        $_SESSION['otp_pending'] = false;
        $_SESSION['authenticated'] = true;

        $response->getBody()->write(json_encode(['valid' => true]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        // If the user is already authenticated, redirect them to the albums page
        if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
            return $response->withHeader('Location', '/albums')->withStatus(302);
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/login.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}