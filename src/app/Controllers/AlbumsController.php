<?php

namespace S246109\BeatMagazine\Controllers;

use S246109\BeatMagazine\Models\Album;

class AlbumsController
{

    public function index()
    {
        $albums = self::getAllAlbums();


        include __DIR__ . '/../Views/albums.php';
    }

    public static function getAllAlbums()
    {
        // This could retrieve data from a database; here we use static data for demonstration
        return [
            new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul", "Electronic", "XL Recordings", 4.5, 4.8, "2019-04-13"),
            new Album("/images/brat.png", "Brat", "Charli XCX", "Pop", "Asylum Records", 4.2, 4.7, "2022-09-16"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton", "Electronica", "100% Electronica", 4.6, 4.9, "2015-11-02"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov", "Indie Rock", "Exploding In Sound", 4.0, 4.3, "2013-07-16"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water", "Shoegaze", "Run For Cover Records", 4.3, 4.5, "2020-10-30"),
            new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul", "Electronic", "XL Recordings", 4.5, 4.8, "2019-04-13"),
            new Album("/images/brat.png", "Brat", "Charli XCX", "Pop", "Asylum Records", 4.2, 4.7, "2022-09-16"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton", "Electronica", "100% Electronica", 4.6, 4.9, "2015-11-02"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov", "Indie Rock", "Exploding In Sound", 4.0, 4.3, "2013-07-16"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water", "Shoegaze", "Run For Cover Records", 4.3, 4.5, "2020-10-30"),
        ];
    }
}