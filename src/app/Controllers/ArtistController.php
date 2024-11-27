<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\ArtistFactory;

class ArtistController
{

    private ArtistFactory $artistFactory;

    /**
     * @param ArtistFactory $artistFactory
     */
    public function __construct(ArtistFactory $artistFactory)
    {
        $this->artistFactory = $artistFactory;
    }


    public function show(Request $request, Response $response, array $args): Response
    {
        $artistName = urldecode(htmlspecialchars($args['artistName']));
        $artist = $this->artistFactory->getArtistByName($artistName);

        ob_start();
        include __DIR__ . '/../Views/artist.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

}