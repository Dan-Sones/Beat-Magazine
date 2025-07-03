<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\ArtistFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Services\ArtistService;
use S246109\BeatMagazine\Services\SessionService;

class ArtistController
{
    private ArtistFactory $artistFactory;
    private AlbumFactory $albumFactory;
    private JournalistReviewFactory $journalistReviewFactory;
    private ArtistService $artistService;
    private SessionService $sessionService;

    /**
     * @param ArtistFactory $artistFactory
     * @param AlbumFactory $albumFactory
     * @param JournalistReviewFactory $journalistReviewFactory
     * @param ArtistService $artistService
     * @param SessionService $sessionService
     */
    public function __construct(
        ArtistFactory           $artistFactory,
        AlbumFactory            $albumFactory,
        JournalistReviewFactory $journalistReviewFactory,
        ArtistService           $artistService,
        SessionService          $sessionService
    )
    {
        $this->artistFactory = $artistFactory;
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
        $this->artistService = $artistService;
        $this->sessionService = $sessionService;
    }

    public function search(Request $request, Response $response, array $args): Response
    {

        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }
        
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
        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['artistName']) || !isset($data['artistBio']) || !isset($data['artistGenre'])) {
            return $response->withStatus(400);
        }

        if ($this->artistService->doesArtistExist($data['artistName'])) {
            return $response->withStatus(409);
        }

        $id = $this->artistService->createArtist($data['artistName'], $data['artistBio'], $data['artistGenre']);

        if (!isset($id)) {
            return $response->withStatus(500);
        }

        $response->getBody()->write(json_encode(['id' => $id]));

        return $response->withStatus(201);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $artistName = urldecode($args['artistName']);

        $artist = $this->artistFactory->getArtistByName($artistName);

        if ($artist) {
            $albums = $this->albumFactory->getAlbumsByArtistName($artistName);
            $journalistReviews = [];

            foreach ($albums as $album) {
                $reviewForAlbum = $this->journalistReviewFactory->getJournalistReviewForAlbum($album->getAlbumID());
                if ($reviewForAlbum) {
                    $journalistReviews[$album->getAlbumID()] = $reviewForAlbum;
                }
            }
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/artist.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }
}