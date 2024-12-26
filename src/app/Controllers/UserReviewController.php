<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\LikeService;
use S246109\BeatMagazine\Services\UserReviewService;

class UserReviewController
{

    private UserReviewService $userReviewService;

    private LikeService $likeService;

    /**
     * @param UserReviewService $userReviewService
     * @param LikeService $likeService
     */
    public function __construct(UserReviewService $userReviewService, LikeService $likeService)
    {
        $this->userReviewService = $userReviewService;
        $this->likeService = $likeService;
    }

    public function create(Request $request, Response $response, array $args): Response
    {

        $userId = $_SESSION['user_id'];

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }


        if (!isset($data['review']) || !isset($data['rating']) || !isset($args['albumId'])) {
            return $response->withStatus(400);
        }


        if ($this->userReviewService->hasUserLeftReviewForAlbum($args['albumId'])) {
            return $response->withStatus(403);
        }


        $success = $this->userReviewService->CreateReviewForAlbum($args['albumId'], $userId, $data['review'], $data['rating']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(201);

    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'];

        if (!isset($userId)) {
            return $response->withStatus(401);
        }

        $data = json_decode($request->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        if (!isset($data['review']) || !isset($data['rating']) || !isset($args['albumId']) || !isset($args['reviewId'])) {
            return $response->withStatus(400);
        }

        $reviewID = $args['reviewId'];
        $albumId = $args['albumId'];

        if (!$this->userReviewService->doesUserOwnReview($reviewID, $userId, $albumId)) {
            return $response->withStatus(403);
        }

        $success = $this->userReviewService->UpdateReviewForAlbum($args['albumId'], $userId, $data['review'], $data['rating']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'];

        if (!isset($userId)) {
            return $response->withStatus(401);
        }

        if (!isset($args['albumId']) || !isset($args['reviewId'])) {
            return $response->withStatus(400);
        }

        $reviewID = $args['reviewId'];
        $albumId = $args['albumId'];

        if (!$this->userReviewService->doesUserOwnReview($reviewID, $userId, $albumId)) {
            return $response->withStatus(403);
        }

        $success = $this->userReviewService->DeleteReviewForAlbum($args['reviewId']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }

    public function like(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'];
        $authenticated = $_SESSION['authenticated'];
        if (!isset($userId) || !isset($authenticated) || !$authenticated) {
            return $response->withStatus(401);
        }

        if (!isset($args['reviewId'])) {
            return $response->withStatus(400);
        }

        $reviewID = $args['reviewId'];

        $success = $this->likeService->likeReview($reviewID, $userId);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);
    }

    public function unlike(Request $request, Response $response, array $args): Response
    {
        $userId = $_SESSION['user_id'];
        $authenticated = $_SESSION['authenticated'];
        if (!isset($userId) || !isset($authenticated) || !$authenticated) {
            return $response->withStatus(401);
        }

        if (!isset($args['reviewId'])) {
            return $response->withStatus(400);
        }

        $reviewID = $args['reviewId'];

        $success = $this->likeService->unlikeReview($reviewID, $userId);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(200);

    }


}