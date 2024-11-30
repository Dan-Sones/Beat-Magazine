<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\services\UserService;

class RegisterController
{

    private userService $userService;

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
        include __DIR__ . '/../Views/register.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }


    public function isUsernameTaken(Request $request, Response $response, array $args): Response
    {
        // get Username from query params
        $username = $request->getQueryParams()['username'];

        // Maybe this should be frontend validation?
//        if (empty($username) || !is_string($username)) {
//            return $response->withStatus(400);
//        }

        $isUsernameTaken = $this->userService->isUsernameTaken($username);

        $response->getBody()->write(json_encode(['taken' => $isUsernameTaken]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }

    public function isEmailTaken(Request $request, Response $response, array $args): Response
    {
        // get Email from query params
        $email = $request->getQueryParams()['email'];

        $isEmailTaken = $this->userService->isEmailTaken($email);

        $response->getBody()->write(json_encode(['taken' => $isEmailTaken]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function submit(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $email = $data['email'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $password = $data['password'];

        try {
            $this->userService->registerUser($email, $username, $password, $firstName, $lastName);
        } catch (\Exception $e) {
            $response->getBody()->write($e->getMessage());
            return $response->withStatus(500);
        }

        return $response->withStatus(201);

    }


}