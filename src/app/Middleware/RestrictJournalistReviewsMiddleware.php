<?php

namespace S246109\BeatMagazine\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Psr7\Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class RestrictJournalistReviewsMiddleware
{
    public function __invoke(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($_SESSION['role'] !== 'journalist') {
            throw new HttpForbiddenException($request);
        }

        return $handler->handle($request);
    }

}