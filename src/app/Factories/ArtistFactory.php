<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Artist;
use S246109\BeatMagazine\Models\Song;

class ArtistFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function getArtistByName(string $name): ?Artist
    {
        return new Artist(
            "Jai Paul",
            "Electronic",
            [
                new Album(
                    1,
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
                        // Additional songs here...
                    ]
                )
            ],
            [
                "Jai Paul's music is a mesmerizing blend of electronic innovation and pop melodies, often heralded as groundbreaking."
            ]
        );

    }
}