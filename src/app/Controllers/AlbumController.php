<?php

namespace S246109\BeatMagazine\Controllers;

use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Song;

class AlbumController
{

    public function index()
    {
        $album = self::getAlbum();

        include __DIR__ . '/../Views/album.php';
    }

    public static function getAlbum()
    {
        return new Album(
            "/images/baitones.jpg",
            "Leak 04-13 (Bait Ones)",
            "Jai Paul",
            "Electronic",
            "XL Recordings",
            4.5,
            4.8,
            "2019-06-01",
            [
                new Song(1, "One of the Bredrins", "0:10"),
                new Song(2, "Str8 Outta Mumbai", "2:42"),
                new Song(3, "Zion Wolf Theme (Unfinished)", "3:07"),
                new Song(4, "Garden of Paradise (Instrumental, Unfinished)", "1:16"),
                new Song(5, "Genevieve (Unfinished)", "3:57"),
                new Song(6, "Raw Beat (Unfinished)", "0:29"),
                new Song(7, "Crush (Unfinished)", "3:45"),
                new Song(8, "Good Time", "0:27"),
                new Song(9, "Jasmine (Demo)", "4:13"),
                new Song(10, "100,000 (Unfinished)", "2:55"),
                new Song(11, "Vibin' (Unfinished)", "2:43"),
                new Song(12, "Baby Beat (Unfinished)", "0:40"),
                new Song(13, "Desert River (Unfinished)", "3:05"),
                new Song(14, "Chix (Unfinished)", "0:56"),
                new Song(15, "All Night (Unfinished)", "3:12"),
                new Song(16, "BTSTU (Demo)", "3:30"),
            ]
        );
    }

}