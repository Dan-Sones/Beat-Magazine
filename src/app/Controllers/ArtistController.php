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


    public function show(Request $request, Response $response, array $args): Response
    {
        $artistName = urldecode(htmlspecialchars($args['artistName']));
        
        $artist = $this->artistFactory->getArtistByName($artistName);
        $albums = $this->albumFactory->getAlbumsByArtistName($artistName);

        ob_start();
        include __DIR__ . '/../Views/artist.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}