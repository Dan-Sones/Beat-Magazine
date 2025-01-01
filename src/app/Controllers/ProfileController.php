<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\JournalistService;
use S246109\BeatMagazine\Services\SessionService;
use S246109\BeatMagazine\Services\UserService;

class ProfileController
{
    private UserFactory $userFactory;
    private UserReviewFactory $userReviewFactory;
    private AlbumFactory $albumFactory;
    private UserService $userService;
    private JournalistReviewFactory $journalistReviewFactory;
    private JournalistService $journalistService;
    private SessionService $sessionService;

    /**
     * @param UserFactory $userFactory
     * @param UserReviewFactory $userReviewFactory
     * @param AlbumFactory $albumFactory
     * @param UserService $userService
     * @param JournalistReviewFactory $journalistReviewFactory
     * @param JournalistService $journalistService
     * @param SessionService $sessionService
     */
    public function __construct(UserFactory $userFactory, UserReviewFactory $userReviewFactory, AlbumFactory $albumFactory, UserService $userService, JournalistReviewFactory $journalistReviewFactory, JournalistService $journalistService, SessionService $sessionService)
    {
        $this->userFactory = $userFactory;
        $this->userReviewFactory = $userReviewFactory;
        $this->albumFactory = $albumFactory;
        $this->userService = $userService;
        $this->journalistReviewFactory = $journalistReviewFactory;
        $this->journalistService = $journalistService;
        $this->sessionService = $sessionService;
    }


    public function show(Request $request, Response $response, array $args): Response
    {
        $username = $args['username'];
        $idForUser = $this->userService->getUserIdFromUsername($username);
        $user = $this->userFactory->getPublicUserByUsername($username);

        if ($user != null) {
            $isJournalist = $user->getRole() === 'journalist';
            $journalistReviews = [];
            $journalistBio = null;

            if ($isJournalist) {
                $journalistReviews = $this->journalistReviewFactory->getAllJournalistReviewsForJournalist($idForUser);
                $journalistBio = $this->journalistService->getJournalistBio($idForUser);
            }

            $userReviews = $this->userReviewFactory->getAllUsersReviews($user);
            $albumIds = array_map(fn($review) => $review->getAlbumId(), $userReviews);

            if (!empty($journalistReviews)) {
                $journalistAlbumIds = array_map(fn($review) => $review->getAlbumId(), $journalistReviews);
                $albumIds = array_merge($albumIds, $journalistAlbumIds);
            }

            $albumDetailsMap = [];
            foreach ($albumIds as $albumId) {
                $album = $this->albumFactory->getAlbumById($albumId);
                if ($album) {
                    $albumDetailsMap[$albumId] = $album;
                }
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
        $userId = $this->sessionService->getUserID();
        if ($userId === null) {
            return $response->withStatus(401);
        }

        $uploadedFiles = $request->getUploadedFiles();
        $profilePicture = $uploadedFiles['profile_picture'] ?? null;

        if ($profilePicture === null) {
            return $response->withStatus(400);
        }

        if ($profilePicture->getError() === UPLOAD_ERR_OK) {
            $allowedMimeTypes = ['image/gif', 'image/jpeg', 'image/png'];
            $fileMimeType = $profilePicture->getClientMediaType();
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                return $response->withStatus(400);
            }

            $this->userService->uploadProfilePicture($profilePicture, $userId);
        }

        return $response->withStatus(200);
    }

    public function updateJournalistBio(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        $userId = $this->sessionService->getUserID();
        if ($userId === null) {
            return $response->withStatus(401);
        }

        $journalistId = $this->journalistService->getJournalistIDByUserID($userId);
        $data = json_decode($request->getBody()->getContents(), true);
        $bio = $data['bio'] ?? null;

        if ($bio === null) {
            return $response->withStatus(400);
        }

        $success = $this->journalistService->updateBio($journalistId, $bio);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }
}