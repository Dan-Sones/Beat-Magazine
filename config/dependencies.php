<?php

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\ArtistFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;
use S246109\BeatMagazine\Factories\UserFactory;
use S246109\BeatMagazine\Factories\UserReviewFactory;
use S246109\BeatMagazine\Services\JournalistReviewService;
use S246109\BeatMagazine\Services\JournalistService;
use S246109\BeatMagazine\Services\UserReviewService;
use S246109\BeatMagazine\Services\UserService;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PDO::class => function () {
            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];
            $charset = 'utf8mb4';


            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            return new PDO($dsn, $user, $pass, $options);
        },
        AlbumFactory::class => function (ContainerInterface $c) {
            return new AlbumFactory($c->get(PDO::class));
        },
        ArtistFactory::class => function (ContainerInterface $c) {
            return new ArtistFactory($c->get(PDO::class));
        },
        JournalistReviewFactory::class => function (ContainerInterface $c) {
            return new JournalistReviewFactory($c->get(PDO::class));
        },
        UserService::class => function (ContainerInterface $c) {
            return new UserService($c->get(PDO::class));
        },
        UserFactory::class => function (ContainerInterface $c) {
            return new UserFactory($c->get(PDO::class));
        },
        UserReviewService::class => function (ContainerInterface $c) {
            return new UserReviewService($c->get(PDO::class), $c->get(UserService::class));
        },
        UserReviewFactory::class => function (ContainerInterface $c) {
            return new UserReviewFactory($c->get(PDO::class), $c->get(UserFactory::class));
        },
        JournalistService::class => function (ContainerInterface $c) {
            return new JournalistService($c->get(PDO::class));
        },
        JournalistReviewService::class => function (ContainerInterface $c) {
            return new JournalistReviewService($c->get(PDO::class));
        },

    ]);
};


