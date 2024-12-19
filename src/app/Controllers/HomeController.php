<?php

namespace S246109\BeatMagazine\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use S246109\BeatMagazine\Services\HomeService;

class HomeController
{

    private HomeService $homeService;

    /**
     * @param HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }


    public function index(Request $request, Response $response, array $args): Response
    {

        $reviews = $this->homeService->getMostRecentJournalistReviewsForHome();

        ob_start();
        include PRIVATE_PATH . '/src/app/Views/home.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);
        return $response;
    }
}