<?php

use S246109\BeatMagazine\Controllers\LoginController;
use S246109\BeatMagazine\Controllers\RegisterController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/register/isUsernameTaken', [RegisterController::class, 'isUsernameTaken']);
        $group->get('/register/isEmailTaken', [RegisterController::class, 'isEmailTaken']);
        $group->post('/register/verify-otp', [RegisterController::class, 'verifyOTP']);
        $group->post('/register', [RegisterController::class, 'submit']);
        $group->post('/login', [LoginController::class, 'login']);
        $group->post('/verify-otp', [LoginController::class, 'verifyOTP']);
    });
};