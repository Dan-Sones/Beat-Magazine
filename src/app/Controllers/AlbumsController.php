<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;


class AlbumsController
{

    private AlbumFactory $albumFactory;

    /**
     * @param AlbumFactory $albumFactory
     */
    public function __construct(AlbumFactory $albumFactory)
    {
        $this->albumFactory = $albumFactory;
    }


    public function index(Request $request, Response $response): Response
    {
        // if there is a query param :genre then filter by genre
        if (isset($request->getQueryParams()['genre'])) {
            $genre = $request->getQueryParams()['genre'];
            error_log('genre: ' . $genre);
            $albums = $this->albumFactory->getAlbumsByGenre($genre);
        } else {
            $albums = $this->albumFactory->getAllAlbums();

        }


        if (isset($_SESSION['role'])) {
            $isJournalist = $_SESSION['role'] === 'journalist';
        } else {
            $isJournalist = false;
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/albums.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

    public function search(Request $request, Response $response, array $args): Response
    {
        $search = $request->getQueryParams()['search'] ?? '';
        if (!is_string($search)) {
            $response->getBody()->write(json_encode([]));
            return $response;
        }

        $search = $request->getQueryParams()['search'] ?? '';
        $albums = $this->albumFactory->searchAlbums($search);

        $response->getBody()->write(json_encode($albums));
        return $response;
    }


}