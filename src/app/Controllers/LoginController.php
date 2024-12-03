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
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

        $user = $this->userFactory->getUserByUsername($username);

        if ($user === null) {
            return $response->withStatus(403);
        }

        if (!password_verify($password, $user['password'])) {
            return $response->withStatus(401);
        }

        $_SESSION['user'] = $user;

        return $response->withStatus(200);
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