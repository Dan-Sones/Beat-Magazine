<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\ArtistFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;

class ArtistController
{

    private ArtistFactory $artistFactory;

    private AlbumFactory $albumFactory;

    private JournalistReviewFactory $journalistReviewFactory;

    /**
     * @param ArtistFactory $artistFactory
     * @param AlbumFactory $albumFactory
     * @param JournalistReviewFactory $journalistReviewFactory
     */
    public function __construct(ArtistFactory $artistFactory, AlbumFactory $albumFactory, JournalistReviewFactory $journalistReviewFactory)
    {
        $this->artistFactory = $artistFactory;
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
    }


    public function search(Request $request, Response $response, array $args): Response
    {
        $search = $request->getQueryParams()['search'] ?? '';
        if (!is_string($search)) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $artists = $this->artistFactory->searchArtists($search);

        $response->getBody()->write(json_encode($artists));
        return $response;
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'];

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'journalist') {
            return $response->withStatus(403);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['artistName']) || !isset($data['artistBio']) || !isset($data['artistGenre'])) {
            return $response->withStatus(400);
        }

        $id = $this->artistFactory->createArtist($data['artistName'], $data['artistBio'], $data['artistGenre']);

        if (!isset($id)) {
            return $response->withStatus(500);
        }

        // return an id JSON property
        $response->getBody()->write(json_encode(['id' => $id]));

        return $response->withStatus(201);

    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $artistName = urldecode(htmlspecialchars($args['artistName']));

        $artist = $this->artistFactory->getArtistByName($artistName);
        $albums = $this->albumFactory->getAlbumsByArtistName($artistName);

        $journalistReviews = [];

        foreach ($albums as $album) {
            $reviewForAlbum = $this->journalistReviewFactory->getJournalistReviewForAlbum($album->getAlbumID());
            if ($reviewForAlbum) {
                $journalistReviews[$album->getAlbumID()] = $reviewForAlbum;
            }
        }

//        error_log(print_r($journalistReviews, true));


        ob_start();
        include PRIVATE_PATH . '/src/app/Views/artist.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}