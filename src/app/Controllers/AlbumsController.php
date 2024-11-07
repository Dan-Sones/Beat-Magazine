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
            new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul"),
            new Album("/images/brat.png", "Brat", "Charli XCX"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water"), new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul"),
            new Album("/images/brat.png", "Brat", "Charli XCX"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water"), new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul"),
            new Album("/images/brat.png", "Brat", "Charli XCX"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water"), new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul"),
            new Album("/images/brat.png", "Brat", "Charli XCX"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water"), new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul"),
            new Album("/images/brat.png", "Brat", "Charli XCX"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water"), new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul"),
            new Album("/images/brat.png", "Brat", "Charli XCX"),
            new Album("/images/100%-Electronica.jpg", "100% Electronica", "George Clanton"),
            new Album("/images/am-ovlov.jpg", "Am", "Ovlov"),
            new Album("/images/s.jpg", "s", "they are gutting a body of water"),
        ];
    }
}