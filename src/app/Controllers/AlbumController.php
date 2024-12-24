<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\AlbumService;
use S246109\BeatMagazine\Services\UserReviewService;

class AlbumController
{

    private AlbumFactory $albumFactory;

    private JournalistReviewFactory $journalistReviewFactory;

    private UserReviewFactory $userReviewFactory;

    private UserReviewService $userReviewService;

    private AlbumService $albumService;

    /**
     * @param AlbumFactory $albumFactory
     * @param JournalistReviewFactory $journalistReviewFactory
     * @param UserReviewFactory $userReviewFactory
     * @param UserReviewService $userReviewService
     * @param AlbumService $albumService
     */
    public function __construct(AlbumFactory $albumFactory, JournalistReviewFactory $journalistReviewFactory, UserReviewFactory $userReviewFactory, UserReviewService $userReviewService, AlbumService $albumService)
    {
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
        $this->userReviewFactory = $userReviewFactory;
        $this->userReviewService = $userReviewService;
        $this->albumService = $albumService;
    }

    public function delete(Request $request, Response $response, array $args): Response
    {

        if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
            return $response->withStatus(401);
        }

        if (!isset($_SESSION['user_id'])) {
            return $response->withStatus(401);
        }

        if ($_SESSION['role'] !== 'journalist') {
            return $response->withStatus(403);
        }


        $albumID = $args['albumId'];
        $success = $this->albumService->deleteAlbum($albumID);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(204);
    }


    public function show(Request $request, Response $response, array $args): Response
    {
        $albumName = urldecode($args['albumName']);
        $artistName = urldecode($args['artistName']);

        $album = $this->albumFactory->getAlbumByName($albumName, $artistName);
        if ($album !== null) {
            $userReviews = $this->userReviewFactory->getAllUserReviewsForAlbum($album->getAlbumID());
            $journalistReview = $this->journalistReviewFactory->getJournalistReviewForAlbum($album->getAlbumID());
            $hasUserLeftReview = $this->userReviewService->hasUserLeftReviewForAlbum($album->getAlbumID());
        }
        $userID = null;

        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
        }

        $isJournalist = false;
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'journalist') {
            $isJournalist = true;
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/album.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }


}