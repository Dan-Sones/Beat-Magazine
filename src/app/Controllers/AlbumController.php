<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;

class AlbumController
{

    private AlbumFactory $albumFactory;

    private JournalistReviewFactory $journalistReviewFactory;

    public function __construct(AlbumFactory $albumFactory, JournalistReviewFactory $journalistReviewFactory)
    {
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $albumName = urldecode($args['albumName']);
        $artistName = urldecode($args['artistName']);

        $album = $this->albumFactory->getAlbumByName($albumName, $artistName);

        $journalistReview = $this->journalistReviewFactory->getJournalistReviewForAlbum($album->getAlbumID());

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/album.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}