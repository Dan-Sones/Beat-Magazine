<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use S246109\BeatMagazine\Services\SessionService;
use S246109\BeatMagazine\Services\UserService;

class RegisterController
{
    private UserService $userService;
    private SessionService $sessionService;

    /**
     * @param UserService $userService
     * @param SessionService $sessionService
     */
    public function __construct(UserService $userService, SessionService $sessionService)
    {
        $this->userService = $userService;
        $this->sessionService = $sessionService;
    }


    public function index(Request $request, Response $response, array $args): Response
    {
        // Redirect to albums if already authenticated
        if ($this->sessionService->isAuthenticated()) {
            return $response->withHeader('Location', '/albums')->withStatus(302);
        }

        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());

        $google2faSecret = $tfa->createSecret();
        $this->sessionService->set('google2faSecret', $google2faSecret);
        $qrCodeUrl = $tfa->getQRCodeImageAsDataUri('BeatMagazine', $google2faSecret);

        $this->sessionService->set('otp_pending', true);

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/register.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

    public function verifyOTP(Request $request, Response $response, array $args): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['otp'])) {
            return $response->withStatus(400);
        }

        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());
        $otp = $data['otp'];

        if (!$tfa->verifyCode($this->getGoogle2faSecret(), $otp)) {
            return $response->withStatus(401);
        }

        $response->getBody()->write(json_encode(['valid' => true]));
        $this->sessionService->set('otp_pending', false);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getGoogle2faSecret(): string
    {
        return $this->sessionService->get('google2faSecret') ?? '';
    }

    public function submit(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $firstName = $data['firstName'] ?? '';
        $lastName = $data['lastName'] ?? '';
        $password = $data['password'] ?? '';
        $google2faSecret = $this->getGoogle2faSecret();

        if ($this->sessionService->get('otp_pending') === true) {
            return $response->withStatus(400);
        }

        if (empty($username) || empty($email) || empty($firstName) || empty($lastName) || empty($password) || empty($google2faSecret)) {
            return $response->withStatus(400);
        }

        if ($this->userService->isUsernameTaken($username)) {
            return $response->withStatus(409);
        }

        if ($this->userService->isEmailTaken($email)) {
            return $response->withStatus(409);
        }

        $confirmNumbers = preg_match_all('/[0-9]/', $password) >= 3;
        $confirmCapital = preg_match_all('/[A-Z]/', $password) >= 1;
        $confirmPunctuation = preg_match_all('/[!@#$%^&*()_+]/', $password) >= 1;
        $confirmLength = strlen($password) >= 8;

        if (!$confirmNumbers || !$confirmCapital || !$confirmPunctuation || !$confirmLength) {
            return $response->withStatus(400);
        }

        try {
            $this->userService->registerUser($email, $username, $password, $firstName, $lastName, $google2faSecret);
        } catch (\Exception $e) {
            $response->getBody()->write($e->getMessage());
            return $response->withStatus(500);
        }

        $this->sessionService->set('google2faSecret', '');

        return $response->withStatus(201);
    }

    public function isUsernameTaken(Request $request, Response $response, array $args): Response
    {
        $username = $request->getQueryParams()['username'] ?? '';

        if (empty($username) || !is_string($username)) {
            return $response->withStatus(400);
        }

        $isUsernameTaken = $this->userService->isUsernameTaken($username);

        $response->getBody()->write(json_encode(['taken' => $isUsernameTaken]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function isEmailTaken(Request $request, Response $response, array $args): Response
    {
        $email = $request->getQueryParams()['email'] ?? '';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $response->withStatus(400);
        }

        $isEmailTaken = $this->userService->isEmailTaken($email);

        $response->getBody()->write(json_encode(['taken' => $isEmailTaken]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}