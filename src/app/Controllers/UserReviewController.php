<?php

namespace S246109\BeatMagazine\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\UserReviewService;

class UserReviewController
{

    private UserReviewService $userReviewService;

    private UserReviewFactory $userReviewFactory;

    /**
     * @param UserReviewService $userReviewService
     * @param UserReviewFactory $userReviewFactory
     */
    public function __construct(UserReviewService $userReviewService, UserReviewFactory $userReviewFactory)
    {
        $this->userReviewService = $userReviewService;
        $this->userReviewFactory = $userReviewFactory;
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


        $success = $this->userReviewService->CreateReviewForAlbum($args['albumId'], $userId, $data['review'], $data['rating']);

        if (!$success) {
            return $response->withStatus(500);
        }

        return $response->withStatus(201);

    }


}