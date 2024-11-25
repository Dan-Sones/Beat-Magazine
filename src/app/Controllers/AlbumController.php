<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\AlbumFactory;

class AlbumController
{

    private AlbumFactory $albumFactory;

    public function __construct(AlbumFactory $albumFactory)
    {
        $this->albumFactory = $albumFactory;
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $albumName = urldecode(htmlspecialchars($args['albumName']));
        $artistName = urldecode(htmlspecialchars($args['artistName']));
        $album = $this->albumFactory->getAlbumByName($albumName, $artistName);

        ob_start();
        include __DIR__ . '/../Views/album.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}