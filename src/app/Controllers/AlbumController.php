<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\AlbumService;
use S246109\BeatMagazine\Services\LikeService;
use S246109\BeatMagazine\Services\UserReviewService;
use S246109\BeatMagazine\Services\SessionService;

class AlbumController
{
    private AlbumFactory $albumFactory;
    private JournalistReviewFactory $journalistReviewFactory;
    private UserReviewFactory $userReviewFactory;
    private UserReviewService $userReviewService;
    private AlbumService $albumService;
    private LikeService $likeService;
    private SessionService $sessionService;

    /**
     * @param AlbumFactory $albumFactory
     * @param JournalistReviewFactory $journalistReviewFactory
     * @param UserReviewFactory $userReviewFactory
     * @param UserReviewService $userReviewService
     * @param AlbumService $albumService
     * @param LikeService $likeService
     * @param SessionService $sessionService
     */
    public function __construct(AlbumFactory $albumFactory, JournalistReviewFactory $journalistReviewFactory, UserReviewFactory $userReviewFactory, UserReviewService $userReviewService, AlbumService $albumService, LikeService $likeService, SessionService $sessionService)
    {
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
        $this->userReviewFactory = $userReviewFactory;
        $this->userReviewService = $userReviewService;
        $this->albumService = $albumService;
        $this->likeService = $likeService;
        $this->sessionService = $sessionService;
    }


    public function delete(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        $albumID = $args['albumId'];

        if ($albumID === null) {
            return $response->withStatus(400);
        }

        $success = $this->albumService->deleteAlbum($albumID);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(204);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $userID = $this->sessionService->getUserID();
        $authenticated = $this->sessionService->isAuthenticated();

        $albumName = urldecode($args['albumName']);
        $artistName = urldecode($args['artistName']);

        $album = $this->albumFactory->getAlbumByName($albumName, $artistName);
        if ($album !== null) {
            $userReviews = $this->userReviewFactory->getAllUserReviewsForAlbum($album->getAlbumID());
            $journalistReview = $this->journalistReviewFactory->getJournalistReviewForAlbum($album->getAlbumID());
            $hasUserLeftReview = $this->userReviewService->hasUserLeftReviewForAlbum($album->getAlbumID(), $userID);
            $averageUserRating = $this->userReviewService->getAverageUserRatingForAlbum($album->getAlbumID());
            if ($userID) {
                $likedReviewsForUser = $this->likeService->getLikedReviewsPerAlbum($album->getAlbumID(), $userID);
            }
        }

        $isJournalist = $this->sessionService->isJournalist();

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/album.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }
}