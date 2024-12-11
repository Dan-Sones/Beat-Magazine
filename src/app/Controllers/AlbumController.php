<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Models\User;
use S246109\BeatMagazine\Services\UserReviewService;
use S246109\BeatMagazine\Services\UserService;

class AlbumController
{

    private AlbumFactory $albumFactory;

    private JournalistReviewFactory $journalistReviewFactory;

    private UserReviewFactory $userReviewFactory;

    private UserReviewService $userReviewService;

    /**
     * @param AlbumFactory $albumFactory
     * @param JournalistReviewFactory $journalistReviewFactory
     * @param UserReviewFactory $userReviewFactory
     * @param UserReviewService $userReviewService
     */
    public function __construct(AlbumFactory $albumFactory, JournalistReviewFactory $journalistReviewFactory, UserReviewFactory $userReviewFactory, UserReviewService $userReviewService)
    {
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
        $this->userReviewFactory = $userReviewFactory;
        $this->userReviewService = $userReviewService;
    }


    public function show(Request $request, Response $response, array $args): Response
    {
        $albumName = urldecode($args['albumName']);
        $artistName = urldecode($args['artistName']);

        $album = $this->albumFactory->getAlbumByName($albumName, $artistName);
        $userReviews = $this->userReviewFactory->getAllUserReviewsForAlbum($album->getAlbumID());
        $journalistReview = $this->journalistReviewFactory->getJournalistReviewForAlbum($album->getAlbumID());


        $hasUserLeftReview = $this->userReviewService->hasUserLeftReviewForAlbum($album->getAlbumID());

        $userID = $_SESSION['user_id'];

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/album.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }


}