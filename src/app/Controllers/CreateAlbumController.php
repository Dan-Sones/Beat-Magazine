<?php

namespace S246109\BeatMagazine\Controllers;


use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Services\AlbumService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateAlbumController
{

    private AlbumService $albumService;

    /**
     * @param AlbumService $albumService
     */
    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }


    public function index(Request $request, Response $response, array $args): Response
    {
        ob_start();
        include PRIVATE_PATH . '/src/app/Views/createAlbum.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'journalist') {
            return $response->withStatus(403);
        }

        $data = $request->getParsedBody();

        error_log(print_r($data, true));

        $uploadedFiles = $request->getUploadedFiles();
        $albumArt = $uploadedFiles['albumArt'] ?? null;

        if ($albumArt === null) {
            return $response->withStatus(400);
        }

        if ($albumArt->getError() === UPLOAD_ERR_OK) {
            // Check if the file is an image
            $fileType = exif_imagetype($albumArt->getStream()->getMetadata('uri'));
            if ($fileType === false) {
                error_log('File is not an image');
                return $response->withStatus(400);
            }

        }

        if (!isset($data['albumName']) || !isset($data['artistID']) || !isset($data['releaseDate']) || !isset($data['genre']) || !isset($data['label']) || !isset($data['songs'])) {
            return $response->withStatus(400);
        }

        $success = $this->albumService->createAlbum($data['albumName'], $data['artistID'], $data['genre'], $data['label'], $data['releaseDate'], json_decode($data['songs'], true), $albumArt);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(201);
    }

}