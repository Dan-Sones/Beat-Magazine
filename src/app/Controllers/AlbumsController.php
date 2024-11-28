<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Song;

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


    //TODO: We can use args here to do sorting eventually
    public function index(Request $request, Response $response): Response
    {
        $albums = $this->albumFactory->getAllAlbums();

        ob_start();
        include __DIR__ . '/../Views/albums.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}