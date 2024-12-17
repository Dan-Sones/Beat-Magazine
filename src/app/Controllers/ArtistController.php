<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\ArtistFactory;

class ArtistController
{

    private ArtistFactory $artistFactory;

    private AlbumFactory $albumFactory;

    /**
     * @param ArtistFactory $artistFactory
     * @param AlbumFactory $albumFactory
     */
    public function __construct(ArtistFactory $artistFactory, AlbumFactory $albumFactory)
    {
        $this->artistFactory = $artistFactory;
        $this->albumFactory = $albumFactory;
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

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/artist.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}