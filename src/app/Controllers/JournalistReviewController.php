<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\JournalistReviewService;
use S246109\BeatMagazine\Services\UserReviewService;

class JournalistReviewController
{

    private JournalistReviewService $journalistReviewService;

    /**
     * @param JournalistReviewService $journalistReviewService
     */
    public function __construct(JournalistReviewService $journalistReviewService)
    {
        $this->journalistReviewService = $journalistReviewService;
    }


    public function create(Request $request, Response $response, array $args): Response
    {

        $userId = $_SESSION['user_id'];


        if (!isset($userId)) {
            return $response->withStatus(401);
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'journalist') {
            return $response->withStatus(403);
        }


        if ($this->journalistReviewService->hasJournalistReviewForAlbum($args['albumId'])) {
            return $response->withStatus(409);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }


        if (!isset($data['review']) || !isset($data['rating']) || !isset($data['abstract']) || !isset($args['albumId'])) {
            return $response->withStatus(400);
        }


        $success = $this->journalistReviewService->createJournalistReviewForAlbum($args['albumId'], $userId, $data['review'], $data['rating'], $data['abstract']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(201);

    }

    public function delete(Request $request, Response $response, array $args): Response
    {

        $userId = $_SESSION['user_id'];


        if (!isset($userId)) {
            return $response->withStatus(401);
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'journalist') {
            return $response->withStatus(403);
        }

        if (!isset($args['albumId'])) {
            return $response->withStatus(400);
        }

        if (!$this->journalistReviewService->hasJournalistReviewForAlbum($args['albumId'])) {
            return $response->withStatus(404);
        }

        if ($userId != $this->journalistReviewService->getJournalistIdForReview($args['albumId'])) {
            error_log($userId);
            error_log($this->journalistReviewService->getJournalistIdForReview($args['albumId']));

            return $response->withStatus(403);
        }

        $success = $this->journalistReviewService->deleteJournalistReviewForAlbum($args['albumId']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);

    }


    public function update(Request $request, Response $response, array $args): Response
    {

        $userId = $_SESSION['user_id'];

        if (!isset($userId)) {
            return $response->withStatus(401);
        }


        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'journalist') {
            return $response->withStatus(403);
        }

        if (!isset($args['albumId'])) {
            return $response->withStatus(400);
        }

        if (!$this->journalistReviewService->hasJournalistReviewForAlbum($args['albumId'])) {
            return $response->withStatus(404);
        }

        if ($userId != $this->journalistReviewService->getJournalistIdForReview($args['albumId'])) {
            return $response->withStatus(403);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['review']) || !isset($data['rating']) || !isset($data['abstract'])) {
            return $response->withStatus(400);
        }

        $success = $this->journalistReviewService->updateJournalistReviewForAlbum($args['albumId'], $data['review'], $data['rating'], $data['abstract']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);

    }


}