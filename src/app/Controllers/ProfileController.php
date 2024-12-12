<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserFactory;

class ProfileController
{
    private UserFactory $userFactory;

    /**
     * @param UserFactory $userFactory
     */
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $username = $args['username'];

        $user = $this->userFactory->getPublicUserByUsername($username);
        if ($user === null) {
            return $response->withStatus(404);
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/profile.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}