<?php

namespace S246109\BeatMagazine\Controllers;

use S246109\BeatMagazine\Models\Album;

class AlbumController
{

    public function index()
    {
        $album = self::getAlbum();

        include __DIR__ . '/../Views/album.php';
    }

    public static function getAlbum()
    {
        return new Album("/images/baitones.jpg", "Leak 04-13 (Bait Ones)", "Jai Paul");
    }

}