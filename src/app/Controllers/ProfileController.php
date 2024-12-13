<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;

class ProfileController
{
    private UserFactory $userFactory;

    private UserReviewFactory $userReviewFactory;

    private AlbumFactory $albumFactory;

    /**
     * @param UserFactory $userFactory
     * @param UserReviewFactory $userReviewFactory
     * @param AlbumFactory $albumFactory
     */
    public function __construct(UserFactory $userFactory, UserReviewFactory $userReviewFactory, AlbumFactory $albumFactory)
    {
        $this->userFactory = $userFactory;
        $this->userReviewFactory = $userReviewFactory;
        $this->albumFactory = $albumFactory;
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $username = $args['username'];

        $user = $this->userFactory->getPublicUserByUsername($username);
        if ($user === null) {
            return $response->withStatus(404);
        }


        $userReviews = $this->userReviewFactory->getAllUsersReviews($user);
        $albumIds = array_map(fn($review) => $review->getAlbumId(), $userReviews);
        $albumDetailsMap = [];

        foreach ($albumIds as $albumId) {
            $album = $this->albumFactory->getAlbumById($albumId);
            if ($album) {
                $albumDetailsMap[$albumId] = $album;
            }
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/profile.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}