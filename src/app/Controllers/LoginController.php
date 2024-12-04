<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\services\UserService;

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
        $_SESSION['firstName'] = $user->getFirstName();
        $_SESSION['lastName'] = $user->getLastName();
        $_SESSION['email'] = $user->getEmail();

        //TODO: Come up with a better format for this and get it from the DB rather than hardcoding
        $_SESSION['role'] = 'COMMUNITY-USER';

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function index(Request $request, Response $response, array $args): Response
    {

        ob_start();
        include __DIR__ . '/../Views/login.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}