<?php

namespace S246109\BeatMagazine\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Psr7\Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class RestrictUserReviewsMiddleware
{

    public function __invoke(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $isAuthenticated = $_SESSION['authenticated'] ?? false;

        if (!$isAuthenticated && $request->getMethod() !== 'GET') {
            throw new HttpForbiddenException($request, 'You are not allowed to perform this action.');
        }

        return $handler->handle($request);
    }

}