<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Services\JournalistReviewService;
use S246109\BeatMagazine\Services\SessionService;

class JournalistReviewController
{
    private JournalistReviewService $journalistReviewService;
    private SessionService $sessionService;

    /**
     * @param JournalistReviewService $journalistReviewService
     * @param SessionService $sessionService
     */
    public function __construct(JournalistReviewService $journalistReviewService, SessionService $sessionService)
    {
        $this->journalistReviewService = $journalistReviewService;
        $this->sessionService = $sessionService;
    }

    public function create(Request $request, Response $response, array $args): Response
    {

        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['review']) || !isset($data['rating']) || !isset($data['abstract']) || !isset($args['albumId'])) {
            return $response->withStatus(400);
        }


        if ($this->journalistReviewService->hasJournalistReviewForAlbum($args['albumId'])) {
            return $response->withStatus(409);
        }

        $userId = $this->sessionService->getUserID();
        $success = $this->journalistReviewService->createJournalistReviewForAlbum($args['albumId'], $userId, $data['review'], $data['rating'], $data['abstract']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(201);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        if (!isset($args['albumId'])) {
            return $response->withStatus(400);
        }

        $albumId = $args['albumId'];


        if (!$this->journalistReviewService->hasJournalistReviewForAlbum($albumId)) {
            return $response->withStatus(404);
        }

        $userId = $this->sessionService->getUserID();
        if ($userId != $this->journalistReviewService->getJournalistUserIdForReview($albumId)) {
            return $response->withStatus(403);
        }


        $success = $this->journalistReviewService->deleteJournalistReviewForAlbum($albumId);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        if (!$this->sessionService->isAuthenticated()) {
            return $response->withStatus(401);
        }

        if (!$this->sessionService->isJournalist()) {
            return $response->withStatus(403);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['review']) || !isset($data['rating']) || !isset($data['abstract']) || !isset($args['albumId'])) {
            return $response->withStatus(400);
        }

        $albumId = $args['albumId'];

        if (!$this->journalistReviewService->hasJournalistReviewForAlbum($albumId)) {
            return $response->withStatus(404);
        }

        $userId = $this->sessionService->getUserID();
        if ($userId != $this->journalistReviewService->getJournalistUserIdForReview($albumId)) {
            return $response->withStatus(403);
        }

        $success = $this->journalistReviewService->updateJournalistReviewForAlbum($args['albumId'], $data['review'], $data['rating'], $data['abstract']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }
}