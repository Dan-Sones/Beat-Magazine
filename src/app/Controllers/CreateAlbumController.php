<?php

namespace S246109\BeatMagazine\Controllers;

use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Services\AlbumService;
use S246109\BeatMagazine\Services\SessionService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateAlbumController
{
    private AlbumService $albumService;
    private SessionService $sessionService;

    /**
     * @param AlbumService $albumService
     * @param SessionService $sessionService
     */
    public function __construct(AlbumService $albumService, SessionService $sessionService)
    {
        $this->albumService = $albumService;
        $this->sessionService = $sessionService;
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(302)->withHeader('Location', '/albums');
        }

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/createAlbum.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isJournalist()) {
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
            $allowedMimeTypes = ['image/gif', 'image/jpeg', 'image/png'];
            $fileMimeType = $albumArt->getClientMediaType();
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                return $response->withStatus(400);
            }
        }

        if (!isset($data['albumName']) || !isset($data['artistID']) || !isset($data['releaseDate']) || !isset($data['genre']) || !isset($data['label']) || !isset($data['songs'])) {
            return $response->withStatus(400);
        }

        if ($this->albumService->doesAlbumExist($data['albumName'], $data['artistID'])) {
            return $response->withStatus(409);
        }

        $success = $this->albumService->createAlbum($data['albumName'], $data['artistID'], $data['genre'], $data['label'], $data['releaseDate'], json_decode($data['songs'], true), $albumArt);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(201);
    }
}