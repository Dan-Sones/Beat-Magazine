<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\HeaderController;
use S246109\BeatMagazine\Controllers\LoginController;
use S246109\BeatMagazine\Controllers\PasswordResetController;
use S246109\BeatMagazine\Controllers\RegisterController;
use S246109\BeatMagazine\Controllers\UserReviewController;
use S246109\BeatMagazine\Middleware\RestrictUserReviewsMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->group('/register', function (RouteCollectorProxy $registerGroup) {
            $registerGroup->get('/isUsernameTaken', [RegisterController::class, 'isUsernameTaken']);
            $registerGroup->get('/isEmailTaken', [RegisterController::class, 'isEmailTaken']);
            $registerGroup->post('/verify-otp', [RegisterController::class, 'verifyOTP']);
            $registerGroup->post('', [RegisterController::class, 'submit']);
        });

        $group->post('/login', [LoginController::class, 'login']);
        $group->post('/verify-otp', [LoginController::class, 'verifyOTP']);
        $group->post('/logout', [HeaderController::class, 'logout']);
        $group->post('/password-reset-request', [PasswordResetController::class, 'handleResetRequest']);

        $group->get('/albums', [AlbumController::class, 'index']);

        $group->group('/albums', function (RouteCollectorProxy $albumGroup) {
            $albumGroup->group('/{albumId}', function (RouteCollectorProxy $albumIdGroup) {
                $albumIdGroup->get('', [AlbumController::class, 'show']);
                $albumIdGroup->group('/reviews', function (RouteCollectorProxy $reviewGroup) {
                    $reviewGroup->get('', [UserReviewController::class, 'index']);
                    $reviewGroup->post('', [UserReviewController::class, 'create']);
                    $reviewGroup->put('/{reviewId}', [UserReviewController::class, 'update']);
                    $reviewGroup->delete('/{reviewId}', [UserReviewController::class, 'delete']);
                })->add(new RestrictUserReviewsMiddleware());
            });


        });

    });
};