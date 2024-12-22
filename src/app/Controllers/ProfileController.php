<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\UserService;

class ProfileController
{
    private UserFactory $userFactory;

    private UserReviewFactory $userReviewFactory;

    private AlbumFactory $albumFactory;

    private UserService $userService;

    /**
     * @param UserFactory $userFactory
     * @param UserReviewFactory $userReviewFactory
     * @param AlbumFactory $albumFactory
     * @param UserService $userService
     */
    public function __construct(UserFactory $userFactory, UserReviewFactory $userReviewFactory, AlbumFactory $albumFactory, UserService $userService)
    {
        $this->userFactory = $userFactory;
        $this->userReviewFactory = $userReviewFactory;
        $this->albumFactory = $albumFactory;
        $this->userService = $userService;
    }


    public function show(Request $request, Response $response, array $args): Response
    {
        $username = $args['username'];


        $idForUser = $this->userService->getUserIdFromUsername($username);

        $user = $this->userFactory->getPublicUserByUsername($username);
        if ($user === null) {
            return $response->withStatus(404);
        }

        $isJournalist = $user->getRole() === 'journalist';

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


    public function uploadProfilePicture(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if ($userId === null) {
            return $response->withStatus(401);
        }

        $uploadedFiles = $request->getUploadedFiles();
        $profilePicture = $uploadedFiles['profile_picture'] ?? null;

        if ($profilePicture === null) {
            return $response->withStatus(400);
        }

        if ($profilePicture->getError() === UPLOAD_ERR_OK) {
            // Check if the file is an image
            $fileType = exif_imagetype($profilePicture->getStream()->getMetadata('uri'));
            if ($fileType === false) {
                return $response->withStatus(400);
            }

            $this->userService->uploadProfilePicture($profilePicture);
        }

        return $response->withStatus(200);
    }

}