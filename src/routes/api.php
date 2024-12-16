<?php

use S246109\BeatMagazine\Controllers\AlbumController;
use S246109\BeatMagazine\Controllers\AlbumsController;
use S246109\BeatMagazine\Controllers\HeaderController;
use S246109\BeatMagazine\Controllers\JournalistReviewController;
use S246109\BeatMagazine\Controllers\LoginController;
use S246109\BeatMagazine\Controllers\PasswordResetController;
use S246109\BeatMagazine\Controllers\ProfileController;
use S246109\BeatMagazine\Controllers\RegisterController;
use S246109\BeatMagazine\Controllers\UpgradeController;
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

        $group->post('/upgrade', [UpgradeController::class, 'upgrade']);

        $group->post('/login', [LoginController::class, 'login']);
        $group->post('/verify-otp', [LoginController::class, 'verifyOTP']);
        $group->post('/logout', [HeaderController::class, 'logout']);
        $group->post('/password-reset-request', [PasswordResetController::class, 'handleResetRequest']);
        $group->post('/password-reset', [PasswordResetController::class, 'resetPassword']);
        $group->post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture']);


        $group->group('/albums', function (RouteCollectorProxy $albumGroup) {
            $albumGroup->get('', [AlbumsController::class, 'search']);
            $albumGroup->group('/{albumId}', function (RouteCollectorProxy $albumIdGroup) {
                $albumIdGroup->get('', [AlbumController::class, 'show']);
                $albumIdGroup->group('/journalist-reviews', function (RouteCollectorProxy $journalistReviewGroup) {
                    $journalistReviewGroup->post('', [JournalistReviewController::class, 'create']);
                    $journalistReviewGroup->put('', [JournalistReviewController::class, 'update']);
                    $journalistReviewGroup->delete('', [JournalistReviewController::class, 'delete']);
                });
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